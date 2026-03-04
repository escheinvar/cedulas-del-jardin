<select wire:change="idiomas()" wire:model="idioma" id="MiIdioma" class="form-control lenguas" style="width:110px; display:inline-block;">
    <option value="es" {{ session('locale') == 'es' ? 'selected' : '' }}>Español</option>
    @if(isset($lenguas))
        @if(in_array('es_mix_bj', $lenguas))
            <option value="es_mix_bj" {{ session('locale') == 'es_mix_bj' ? 'selected' : '' }}>Tu'un Savi (Mixteco Bajo)</option>
        @endif
        
        @if(in_array('pt', $lenguas))
            <option value="pt" {{ session('locale') == 'pt' ? 'selected' : '' }}>Português</option>
        @endif

        @if(in_array('en', $lenguas))
            <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>English</option>
        @endif

        @if(in_array('es_za_va', $lenguas))
            <option value="es_za_va" {{ session('locale') == 'es_za_va' ? 'selected' : '' }}>Zapoteco Valles</option>
        @endif

        @if(in_array('es_za_is', $lenguas))
            <option value="es_za_is" {{ session('locale') == 'es_za_is' ? 'selected' : '' }}>Zapoteco Istmo</option>
        @endif

        @if(in_array('fr', $lenguas))
            <option value="fr" {{ session('locale') == 'fr' ? 'selected' : '' }}>France</option>
        @endif
    @endif
</select>

{{-- ####################################################
    public $idioma, $lenguas=['pt','en','es_mix'];

    public function mount(){
      $this->idioma= session('locale');
    }

    public function idiomas(){
        session(['locale'=> $this->idioma]);
        App::setLocale($this->idioma);
        redirect('/'); 
    }
--}}
