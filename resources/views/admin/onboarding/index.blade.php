@extends('admin.onboarding.layout')

@section('content')
    <div x-data="onboardingWizard()" class="onboarding-flow">
        <!-- Progress Indicator -->
        <div class="setup-steps" style="margin-bottom: 40px;">
            <div class="step-dot" :class="step >= 1 ? 'completed' : ''">
                <template x-if="step > 1"><i data-feather="check" style="width:14px;"></i></template>
                <template x-if="step == 1">1</template>
            </div>
            <div class="step-dot" :class="step >= 2 ? (step > 2 ? 'completed' : 'active') : ''">
                <template x-if="step > 2"><i data-feather="check" style="width:14px;"></i></template>
                <template x-if="step <= 2">2</template>
            </div>
            <div class="step-dot" :class="step >= 3 ? (step > 3 ? 'completed' : 'active') : ''">
                <template x-if="step > 3"><i data-feather="check" style="width:14px;"></i></template>
                <template x-if="step <= 3">3</template>
            </div>
            <div class="step-dot" :class="step == 4 ? 'active' : ''">4</div>
        </div>

        <!-- Step 1: Identitas Sekolah -->
        <div x-show="step == 1" x-transition>
            <div class="setup-title">Identitas Sekolah</div>
            <p class="setup-description">Masukkan nama dan logo resmi sekolah Anda.</p>

            <div class="form-group">
                <label>Nama Sekolah</label>
                <input type="text" x-model="formData.school_name" class="form-control" placeholder="Contoh: SDIT Al Irsyad">
            </div>
            <div class="form-group">
                <label>Tagline / Slogan</label>
                <input type="text" x-model="formData.school_tagline" class="form-control"
                    placeholder="Contoh: Cerdas, Berakhlak, Mandiri">
            </div>

            <button @click="nextStep" class="btn-setup">Lanjutkan <i data-feather="arrow-right"></i></button>
        </div>

        <!-- Step 2: Kontak & Lokasi -->
        <div x-show="step == 2" x-transition>
            <div class="setup-title">Kontak & Lokasi</div>
            <p class="setup-description">Informasi ini akan muncul di bagian bawah website dan halaman kontak.</p>

            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" x-model="formData.school_phone" class="form-control" placeholder="021-xxxxxxx">
            </div>
            <div class="form-group">
                <label>Email Sekolah</label>
                <input type="email" x-model="formData.school_email" class="form-control" placeholder="info@sekolah.sch.id">
            </div>
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea x-model="formData.school_address" class="form-control" rows="3"
                    placeholder="Jl. Pendidikan No. 123..."></textarea>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button @click="step--" class="btn-setup" style="background: #f1f5f9; color: var(--text);">Kembali</button>
                <button @click="nextStep" class="btn-setup">Lanjutkan <i data-feather="arrow-right"></i></button>
            </div>
        </div>

        <!-- Step 3: Visi & Misi -->
        <div x-show="step == 3" x-transition>
            <div class="setup-title">Visi & Misi</div>
            <p class="setup-description">Berikan gambaran singkat mengenai tujuan sekolah Anda.</p>

            <div class="form-group">
                <label>Visi</label>
                <textarea x-model="formData.school_vision" class="form-control" rows="3"
                    placeholder="Menjadi sekolah unggulan..."></textarea>
            </div>
            <div class="form-group">
                <label>Misi</label>
                <textarea x-model="formData.school_mission" class="form-control" rows="4"
                    placeholder="1. Menyelenggarakan pendidikan..."></textarea>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button @click="step--" class="btn-setup" style="background: #f1f5f9; color: var(--text);">Kembali</button>
                <button @click="submitOnboarding" class="btn-setup" :disabled="loading">
                    <span x-show="!loading">Selesaikan Setup <i data-feather="check"></i></span>
                    <span x-show="loading">Menyimpan...</span>
                </button>
            </div>
        </div>

        <!-- Footer Skip Option -->
        <div style="margin-top: 40px; text-align: center;" x-show="step < 4">
            <a href="{{ route('admin.onboarding.skip') }}" class="onboarding-skip"
                onclick="return confirm('Anda yakin ingin melewati setup ini? Anda tetap bisa mengaturnya nanti di Dashboard.')">
                Lewati setup untuk sekarang &rarr;
            </a>
        </div>
    </div>

    @push('scripts')
        <script>
            function onboardingWizard() {
                return {
                    step: 1,
                    loading: false,
                    formData: {
                        school_name: '',
                        school_tagline: '',
                        school_phone: '',
                        school_email: '',
                        school_address: '',
                        school_vision: '',
                        school_mission: ''
                    },
                    nextStep() {
                        this.step++;
                        setTimeout(() => feather.replace(), 50);
                    },
                    submitOnboarding() {
                        this.loading = true;
                        fetch("{{ route('admin.onboarding.save') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(this.formData)
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    window.location.href = "{{ route('admin.dashboard') }}";
                                }
                            })
                            .catch(err => {
                                alert('Terjadi kesalahan saat menyimpan data.');
                                this.loading = false;
                            });
                    }
                }
            }
        </script>
    @endpush
@endsection