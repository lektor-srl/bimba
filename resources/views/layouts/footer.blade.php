@section('footer')
    <footer id="footer" class="uk-section uk-margin-remove uk-section-xsmall uk-text-small uk-text-muted border-top">
        <div class="uk-container">
            <div class="uk-child-width-1-2@m uk-text-center" uk-grid="">
                <div class="uk-flex-first@m uk-text-left@m">
                    <p class="uk-text-small">Lektor S.r.l. {{ date('Y') }}
                        - {{ 'Laravel '.app()->version().' - PHP '.phpversion() }}</p>
                </div>
            </div>
        </div>
    </footer>
@endsection
