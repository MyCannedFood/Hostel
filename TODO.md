# TODO - Penyesuaian Admin/Settings Landing translate + database

- [ ] Update `app/Models/LandingPageSetting.php`: ubah `DEFAULTS` dari English menjadi struktur data bilingual (en/id) sesuai hardcode di `resources/views/home/sections/*`.
- [ ] Pastikan key bilingual yang dipakai section view ada di `DEFAULTS` (mis: `headline_id`, `tagline_id`, `title_id`, `subtitle_id`, dst).
- [ ] (Jika perlu) rapikan mismatch subkey di `resources/views/admin/settings/partials/landing-page-settings.blade.php` supaya mapping `sub` konsisten dengan controller/model.
- [ ] Jalankan test manual:
  - [ ] Buka `Admin/Settings?section=landing` dan cek default tampil bahasa ID.
  - [ ] Toggle bahasa via navbar; pastikan teks berubah sesuai `alas:langchange`.
- [ ] Jalankan pemeriksaan cepat: pastikan tidak ada error PHP/undefined index pada render landing sections.
