<div>
    <select id="language_control" name="language_control" onchange="location = this.value;">
        @foreach(config('app.locales') as $locale)
            <option value="{{ route('language.switch', $locale) }}" {{ app()->getLocale() == $locale ? 'selected' : '' }}>
                {{ strtoupper($locale) }}
            </option>
        @endforeach
    </select>
</div>
