<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\VisitHandler;
use App\Models\SocialMedia;
use App\Models\Banner;
use App\Models\Faq;
use App\Models\Product;
use App\Traits\HandleActiveUser;

class HomeController extends Controller
{
    use VisitHandler, HandleActiveUser;

    public function index(Request $request, $slug = null)
    {
        // Panggil visit handler supaya tercatat
        $this->incrementVisit($slug);

        $data = $this->getActiveUserData($slug);

        $products = Product::where('is_featured', '1')
            ->limit(4)
            ->get();

        $faqs = Faq::where('featured', 'Featured')
            ->limit(5)
            ->get();

        $jumbo_banner = Banner::where('jenis_banner', 'jumbo')->get();
        $mini_banner = Banner::where('jenis_banner', 'mini')->get();

        return view('home.index', array_merge($data, [
            'products' => $products,
            'mbanner' => $mini_banner,
            'jbanner' => $jumbo_banner,
            'faq' => $faqs,
            'title' => 'Home | Metro Display ADV',
        ]));
    }


    public function about(Request $request, $slug = null)
    {
        $data = $this->getActiveUserData($slug);
        return view('home.about', $data);
    }

    public function category(Request $request, $slug = null)
    {
        $user = $this->incrementVisit($slug);

        if ($slug && !$user) {
            abort(404);
        }

        $socialMediaData = $this->getSocialMediaData($slug, $user);

        return view('home.category', [
            'socialMedia' => $socialMediaData
        ]);
    }

    public function faq(Request $request, $slug = null)
    {
        $faqs = Faq::orderByRaw("CASE WHEN featured = 'Featured' THEN 0 ELSE 1 END")
            ->orderBy('id', 'asc')
            ->get();

        $data = $this->getActiveUserData($slug);
        return view('home.faq', $data, compact('faqs'));
    }

}
