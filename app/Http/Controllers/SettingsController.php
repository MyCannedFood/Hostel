<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\GeneralSetting;
use App\Models\LandingPageSetting;
use App\Models\Role;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\SiteSetting;
use App\Models\TransportationInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\FooterSettingsRequest;
use App\Models\PaymentSetting;
use App\Models\BankAccount;
use App\Models\PaymentMethod;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->get('section', 'gallery');
        $data    = ['section' => $section];

        /* ── Gallery ── */
        if ($section === 'gallery') {
            $query = Gallery::query();
            if ($request->filled('category') && $request->category !== 'all')
                $query->where('category', $request->category);
            if ($request->filled('status') && $request->status !== 'all')
                $query->where('status', $request->status);

            $data['photos']         = $query->orderBy('column_placement')->orderBy('order_number')
                                            ->paginate(10)->appends($request->except('page'));
            $data['totalPhotos']    = Gallery::count();
            $data['filterCategory'] = $request->get('category', 'all');
            $data['filterStatus']   = $request->get('status', 'all');
        }

        /* ── Staff ── */
        if ($section === 'staff') {
            $tab = $request->get('tab', 'staff-list');
            if ($tab === 'staff-list') {
                $query = Admin::with('role');
                if ($request->filled('search'))
                    $query->where('name', 'like', '%' . $request->search . '%');
                $data['staffList'] = $query->orderBy('name')->get();
            }
            if ($tab === 'access-info')
                $data['roles'] = Role::withCount('admins')->orderBy('name')->get();
            $data['roleOptions'] = Role::orderBy('name')->get();
        }

        /* ── General Settings ── */
        if ($section === 'general') {
            $sub = $request->get('sub');
            $data['user'] = Auth::guard('admin')->user();

            if ($sub === 'payment-methods') {
                $data['settings'] = PaymentSetting::instance();
                $data['banks']    = BankAccount::ordered()->get();
                $data['methods']  = PaymentMethod::ordered()->get();
            }

            if ($sub === 'footer') {
                $data['footer'] = [
                    'brand_desc'         => SiteSetting::get('footer_brand_desc',         'A sanctuary where Javanese heritage meets modern ecological luxury.'),
                    'brand_desc_id'      => SiteSetting::get('footer_brand_desc_id',      ''),
                    'newsletter_text'    => SiteSetting::get('footer_newsletter_text',    'Subscribe for seasonal updates and exclusive retreat offers.'),
                    'newsletter_text_id' => SiteSetting::get('footer_newsletter_text_id', ''),
                    'instagram_url'      => SiteSetting::get('footer_instagram_url',      ''),
                    'facebook_url'       => SiteSetting::get('footer_facebook_url',       ''),
                    'pinterest_url'      => SiteSetting::get('footer_pinterest_url',      ''),
                    'copyright_text'     => SiteSetting::get('footer_copyright_text',     '© 2026 ALASARE ECO-SANCTUARY. ALL RIGHTS RESERVED.'),
                    'copyright_text_id'  => SiteSetting::get('footer_copyright_text_id',  ''),
                    'privacy_url'        => SiteSetting::get('footer_privacy_url',        '/legal/privacy-policy'),
                    'terms_url'          => SiteSetting::get('footer_terms_url',          '/legal/terms'),
                ];
            }

            // Hostel info / operational policies
            $sectionKey = match ($sub) {
                'hostel-info'           => 'hostel_info',
                'operational-policies'  => 'operational_policies',
                default                 => null,
            };

            if ($sectionKey) {
                $setting = GeneralSetting::getSection($sectionKey);
                $data['settings'] = array_merge(
                    GeneralSetting::DEFAULTS[$sectionKey],
                    $setting->data ?? []
                );
                $data['settings']['_section'] = Str::slug($sub);
            }
        }

        /* ── Landing Page ── */
        if ($section === 'landing') {
            $sub = $request->get('sub');

            match ($sub) {
                'hero'              => $data['heroSettings']          = LandingPageSetting::getSection('hero'),
                'philosophy'        => $data['philosophySettings']    = LandingPageSetting::getSection('philosophy'),
                'flora'             => $data['floraSettings']         = LandingPageSetting::getSection('flora'),
                'map'               => $data['mapSettings']           = LandingPageSetting::getSection('map'),
                'featured-rooms',
                'rooms'             => $this->prepareFeaturedRoomsData($data),
                'featured-articles' => $this->prepareFeaturedArticlesData($data),
                'guest-stories'     => $data['guestStoriesSettings']  = LandingPageSetting::getSection('guest_stories'),
                'awards'            => $data['awardsSettings']        = LandingPageSetting::getSection('awards'),
                'media-partners'    => $data['mediaPartnersSettings'] = LandingPageSetting::getSection('media_partners'),
                'gallery'           => $data['gallerySettings']       = LandingPageSetting::getSection('gallery'),
                default             => null,
            };
        }

        /* ── Location ── */
        if ($section === 'location') {
            $data['address']      = SiteSetting::get('address', '');
            $data['phone']        = SiteSetting::get('phone', '');
            $data['publicEmail']  = SiteSetting::get('public_email', '');
            $data['mapsLink']     = SiteSetting::get('maps_link', '');
            $data['contactEmail'] = SiteSetting::get('contact_form_email', '');
            $data['transports']   = TransportationInfo::orderBy('sort_order')->orderBy('id')->get();
        }

        return view('admin.settings.settings', $data);
    }

    private function prepareFeaturedRoomsData(array &$data): null
    {
        $setting = LandingPageSetting::getSection('featured_rooms');
        $payload = array_merge(
            LandingPageSetting::DEFAULTS['featured_rooms'],
            $setting->data ?? []
        );

        $selectedIds = collect($payload['room_ids'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        $allRooms = Room::withCount('beds')
            ->orderBy('name')
            ->get();

        $selectedRooms = $allRooms
            ->whereIn('id', $selectedIds)
            ->sortBy(fn ($room) => $selectedIds->search($room->id))
            ->values();

        if (!$setting->exists && $selectedRooms->isEmpty()) {
            $selectedRooms = $allRooms
                ->where('is_active', true)
                ->take(3)
                ->values();
            $payload['room_ids'] = $selectedRooms->pluck('id')->all();
        }

        $data['featuredRoomsSettings'] = $setting;
        $data['featuredRoomsData']     = $payload;
        $data['selectedRoomIds']       = collect($payload['room_ids'])->map(fn ($id) => (int) $id)->all();
        $data['selectedRooms']         = $selectedRooms;
        $data['allRooms']              = $allRooms;

        return null;
    }

    private function prepareFeaturedArticlesData(array &$data): null
    {
        $setting = LandingPageSetting::getSection('featured_articles');

        $payload = array_merge(
            LandingPageSetting::DEFAULTS['featured_articles'],
            $setting->data ?? []
        );

        $selectedIds = collect($payload['article_ids'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        $allArticles = Article::where('status', 'Published')
            ->where(function ($q) {
                $q->whereNull('publish_at')
                  ->orWhere('publish_at', '<=', now());
            })
            ->orderByDesc('publish_at')
            ->orderByDesc('created_at')
            ->get();

        $selectedArticles = $allArticles
            ->whereIn('id', $selectedIds)
            ->sortBy(fn ($article) => $selectedIds->search($article->id))
            ->values();

        $data['featuredArticlesSetting'] = $setting;
        $data['featuredArticlesData']    = $payload;
        $data['selectedArticles']        = $selectedArticles;
        $data['allArticles']             = $allArticles;

        return null;
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        $data  = $request->validated();

        // ── Basic info ────────────────────────────────────────────────────
        $admin->name  = $data['full_name'];
        $admin->email = $data['email'];
        $admin->phone = $data['phone'] ?? $admin->phone;

        // ── Avatar (base64 dari crop modal) ───────────────────────────────
        if (!empty($data['avatar_data'])) {
            // Hapus avatar lama
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }

            $base64   = preg_replace('/^data:image\/\w+;base64,/', '', $data['avatar_data']);
            $decoded  = base64_decode($base64);
            $filename = 'avatars/' . $admin->id . '_' . Str::random(8) . '.png';
            Storage::disk('public')->put($filename, $decoded);

            $admin->avatar = $filename;
        }

        // ── Password ──────────────────────────────────────────────────────
        if (!empty($data['new_password'])) {
            if (!Hash::check($data['current_password'], $admin->password)) {
                return back()
                    ->withErrors(['current_password' => 'Password lama tidak sesuai.'])
                    ->withInput($request->except(['current_password', 'new_password', 'new_password_confirmation']));
            }
            $admin->password = Hash::make($data['new_password']);
        }

        $admin->save();

        return redirect()
            ->route('admin.settings', ['section' => 'general', 'sub' => 'profile'])
            ->with('success', 'Profil berhasil disimpan.');
    }

    public function footerUpdate(FooterSettingsRequest $request)
    {
        $d = $request->validated();

        SiteSetting::set('footer_brand_desc',         $d['brand_desc']         ?? '');
        SiteSetting::set('footer_brand_desc_id',      $d['brand_desc_id']      ?? '');
        SiteSetting::set('footer_newsletter_text',    $d['newsletter_text']    ?? '');
        SiteSetting::set('footer_newsletter_text_id', $d['newsletter_text_id'] ?? '');
        SiteSetting::set('footer_instagram_url',      $d['instagram_url']      ?? '');
        SiteSetting::set('footer_facebook_url',       $d['facebook_url']       ?? '');
        SiteSetting::set('footer_pinterest_url',      $d['pinterest_url']      ?? '');
        SiteSetting::set('footer_copyright_text',     $d['copyright_text']     ?? '');
        SiteSetting::set('footer_copyright_text_id',  $d['copyright_text_id']  ?? '');
        SiteSetting::set('footer_privacy_url',        $d['privacy_url']        ?? '');
        SiteSetting::set('footer_terms_url',          $d['terms_url']          ?? '');

        return redirect()
            ->route('admin.settings', ['section' => 'general', 'sub' => 'footer'])
            ->with('success', 'Footer settings berhasil disimpan.');
    }
}