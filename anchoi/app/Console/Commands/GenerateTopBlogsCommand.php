<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Category;
use App\Models\EntertainmentSpot;
use App\Models\EntertainmentType;
use App\Models\Province;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateTopBlogsCommand extends Command
{
    protected $signature = 'blog:generate-top {--min=3 : Số địa điểm tối thiểu để tạo bài} {--limit=10 : Số địa điểm tối đa trong bài}';
    protected $description = 'Sinh bài blog "Top X {loại hình} tại {tỉnh}" từ dữ liệu địa điểm (nội dung gốc + internal link)';

    public function handle()
    {
        $min = (int) $this->option('min');
        $limit = (int) $this->option('limit');
        $category = Category::firstOrCreate(['name' => 'Cẩm nang đi chơi']);

        $created = 0;
        $updated = 0;

        foreach (EntertainmentType::all() as $type) {
            foreach (Province::all() as $prov) {
                $spots = EntertainmentSpot::with(['ward', 'entertainmentType'])
                    ->where('status', 'approved')
                    ->where('entertainment_type_id', $type->id)
                    ->whereHas('ward', fn ($q) => $q->where('province_id', $prov->id))
                    ->orderByDesc('average_rating')->orderByDesc('id')
                    ->take($limit)->get();

                $n = $spots->count();
                if ($n < $min) {
                    continue;
                }

                $title = $n >= 2
                    ? "Top {$n} {$type->name} tại {$prov->name}"
                    : "{$type->name} nổi bật tại {$prov->name}";

                $blog = Blog::firstOrNew(['title' => $title]);
                $exists = $blog->exists;

                $blog->body = $this->buildBody($type, $prov, $spots);
                $blog->category_id = $category->id;
                $blog->banner_image = $blog->banner_image ?: optional($spots->first())->banner_image;
                $blog->save();

                $exists ? $updated++ : $created++;
                $this->line(($exists ? '↻ ' : '＋ ') . $title . " ({$n})");
            }
        }

        $this->info("Xong: tạo mới {$created}, cập nhật {$updated} bài.");
        return self::SUCCESS;
    }

    /** Thân bài HTML: nội dung gốc từ data + internal link tới từng trang địa điểm. */
    private function buildBody(EntertainmentType $type, Province $prov, $spots): string
    {
        $tl = Str::lower($type->name);
        $html = "<p>Bạn đang tìm <strong>{$tl}</strong> tại {$prov->name}? Dưới đây là {$spots->count()} địa điểm {$tl} nổi bật tại {$prov->name}, "
            . "tổng hợp kèm địa chỉ, số điện thoại, bản đồ chỉ đường và đánh giá từ cộng đồng để bạn dễ dàng lựa chọn.</p>";

        foreach ($spots as $i => $spot) {
            $url = $spot->entertainmentType->slug . '-' . $spot->ward->slug . '/' . $spot->slug;
            $stt = $i + 1;
            $html .= "<h2>{$stt}. <a href=\"/{$url}\">" . e($spot->name) . "</a></h2>";
            $line = "<p>Địa chỉ: " . e($spot->full_address);
            if ($spot->phone_number) {
                $line .= ". Điện thoại: " . e($spot->phone_number);
            }
            if ($spot->average_rating > 0) {
                $line .= ". Đánh giá: {$spot->average_rating}/5";
            }
            $line .= ".</p>";
            $html .= $line;

            $desc = trim(strip_tags($spot->description ?? ''));
            if ($desc) {
                $html .= '<p>' . e(Str::limit($desc, 220)) . '</p>';
            }
            $html .= "<p><a href=\"/{$url}\">Xem chi tiết {$spot->name} &rarr;</a></p>";
        }

        $html .= "<p>Trên đây là danh sách {$tl} tại {$prov->name} đáng chú ý nhất. "
            . "Nhấn vào từng địa điểm để xem bản đồ, giờ mở cửa và đánh giá mới nhất từ người dùng.</p>";

        return $html;
    }
}
