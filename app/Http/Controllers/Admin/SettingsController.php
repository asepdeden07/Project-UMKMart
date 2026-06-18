<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateHeroBannerRequest;
use App\Http\Requests\UpdateWebsiteLogoRequest;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display settings management page
     */
    public function index()
    {
        $heroBanner = WebsiteSetting::get('hero_banner');
        $websiteLogo = WebsiteSetting::get('website_logo');
        $headerDescription = WebsiteSetting::get('header_description');
        $footerDescription = WebsiteSetting::get('footer_description');

        // BARU: Ambil data kontak dan identitas toko dari key-value database
        $storeName = WebsiteSetting::get('store_name', 'UMKMart'); // default UMKMart jika kosong
        $footerAddress = WebsiteSetting::get('footer_address');
        $footerEmail = WebsiteSetting::get('footer_email');
        $footerPhone = WebsiteSetting::get('footer_phone');
        $footerOpenHours = WebsiteSetting::get('footer_open_hours');

        // Lempar semua variabel ke view lewat compact()
        return view('admin.settings.index', compact(
            'heroBanner', 
            'websiteLogo', 
            'headerDescription', 
            'footerDescription',
            'storeName',
            'footerAddress',
            'footerEmail',
            'footerPhone',
            'footerOpenHours'
        ));
    }

    /**
     * Update hero banner
     */
    public function updateHeroBanner(UpdateHeroBannerRequest $request)
    {
        if ($request->hasFile('hero_banner')) {
            // Get current image and delete
            $currentBanner = WebsiteSetting::get('hero_banner');
            if ($currentBanner && Storage::disk('public')->exists($currentBanner)) {
                Storage::disk('public')->delete($currentBanner);
            }

            // Upload new image
            $imagePath = $request->file('hero_banner')->store('website-assets', 'public');
            WebsiteSetting::set('hero_banner', $imagePath);

            return redirect()->route('admin.settings.index')
                ->with('success', 'Hero Banner berhasil diperbarui');
        }

        return back()->with('error', 'Pilih gambar terlebih dahulu');
    }

    /**
     * Update website logo
     */
    public function updateWebsiteLogo(UpdateWebsiteLogoRequest $request)
    {
        if ($request->hasFile('website_logo')) {
            // Get current logo and delete
            $currentLogo = WebsiteSetting::get('website_logo');
            if ($currentLogo && Storage::disk('public')->exists($currentLogo)) {
                Storage::disk('public')->delete($currentLogo);
            }

            // Upload new logo
            $imagePath = $request->file('website_logo')->store('website-assets', 'public');
            WebsiteSetting::set('website_logo', $imagePath);

            return redirect()->route('admin.settings.index')
                ->with('success', 'Logo Website berhasil diperbarui');
        }

        return back()->with('error', 'Pilih gambar terlebih dahulu');
    }

    /**
     * Delete hero banner
     */
    public function deleteHeroBanner()
    {
        $bannerPath = WebsiteSetting::get('hero_banner');
        if ($bannerPath && Storage::disk('public')->exists($bannerPath)) {
            Storage::disk('public')->delete($bannerPath);
        }

        WebsiteSetting::set('hero_banner', null);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Hero Banner berhasil dihapus');
    }

    /**
     * Delete website logo
     */
    public function deleteWebsiteLogo()
    {
        $logoPath = WebsiteSetting::get('website_logo');
        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
            Storage::disk('public')->delete($logoPath);
        }

        WebsiteSetting::set('website_logo', null);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Logo Website berhasil dihapus');
    }

    /**
     * Update website header, footer descriptions, and store details
     */
    public function updateWebsiteDetails(\Illuminate\Http\Request $request)
    {
        // Menyimpan teks deskripsi ke database key-value
        WebsiteSetting::set('header_description', $request->header_description);
        WebsiteSetting::set('footer_description', $request->footer_description);

        // BARU: Menyimpan data identitas toko dan kontak baru ke database key-value
        WebsiteSetting::set('store_name', $request->store_name);
        WebsiteSetting::set('footer_address', $request->footer_address);
        WebsiteSetting::set('footer_email', $request->footer_email);
        WebsiteSetting::set('footer_phone', $request->footer_phone);
        WebsiteSetting::set('footer_open_hours', $request->footer_open_hours);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Informasi detail dan kontak website berhasil diperbarui');
    }

    public function updateHeroBackground(Request $request)
{
    $request->validate(['hero_background' => 'image|mimes:jpeg,png,jpg|max:2048']);

    if ($request->hasFile('hero_background')) {
        $currentBg = WebsiteSetting::get('hero_background');
        if ($currentBg && \Illuminate\Support\Facades\Storage::disk('public')->exists($currentBg)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($currentBg);
        }

        $path = $request->file('hero_background')->store('website-assets', 'public');
        WebsiteSetting::set('hero_background', $path);

        return back()->with('success', 'Background Hero berhasil diperbarui');
    }
    return back()->with('error', 'Pilih gambar terlebih dahulu');
}
}