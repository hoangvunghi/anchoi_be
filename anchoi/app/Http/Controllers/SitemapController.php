<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\EntertainmentSpot;
use App\Models\EntertainmentType;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $urls = [];

        // Trang tĩnh
        $urls[] = ['loc' => url('/'), 'priority' => '1.0'];
        $urls[] = ['loc' => url('/blog'), 'priority' => '0.6'];
        $urls[] = ['loc' => url('/contact'), 'priority' => '0.3'];

        // Trang loại hình (/club, /karaoke, ...)
        foreach (EntertainmentType::pluck('slug') as $slug) {
            $urls[] = ['loc' => url('/' . $slug), 'priority' => '0.8'];
        }

        // Tất cả địa điểm đã duyệt
        EntertainmentSpot::with(['ward', 'entertainmentType'])
            ->where('status', 'approved')
            ->whereHas('ward')->whereHas('entertainmentType')
            ->chunk(500, function ($spots) use (&$urls) {
                foreach ($spots as $spot) {
                    $path = $spot->entertainmentType->slug . '-' . $spot->ward->slug . '/' . $spot->slug;
                    $urls[] = ['loc' => url('/' . $path), 'lastmod' => $spot->updated_at?->toAtomString(), 'priority' => '0.7'];
                }
            });

        // Bài blog
        foreach (Blog::all() as $blog) {
            $urls[] = ['loc' => url('/blog/' . $blog->slug), 'lastmod' => $blog->updated_at?->toAtomString(), 'priority' => '0.5'];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= '  <url><loc>' . htmlspecialchars($u['loc']) . '</loc>';
            if (!empty($u['lastmod'])) {
                $xml .= '<lastmod>' . $u['lastmod'] . '</lastmod>';
            }
            $xml .= '<priority>' . $u['priority'] . '</priority></url>' . "\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $txt = "User-agent: *\nAllow: /\n\nSitemap: " . url('/sitemap.xml') . "\n";
        return response($txt, 200)->header('Content-Type', 'text/plain');
    }
}
