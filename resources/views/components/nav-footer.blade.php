<footer class="uk-section uk-section-default">
    <div class="uk-container uk-text-secondary uk-text-500">
        <div class="uk-child-width-1-2@s" data-uk-grid>
            <div>
                <a href="#" class="uk-logo">Cuisine</a>
            </div>
            <div class="uk-flex uk-flex-middle uk-flex-right@s">
                <div data-uk-grid class="uk-child-width-auto uk-grid-small">
                    <div>
                        <a href="https://www.facebook.com/" data-uk-icon="icon: facebook; ratio: 0.8"
                            class="uk-icon-button facebook" target="_blank"></a>
                    </div>
                    <div>
                        <a href="https://www.instagram.com/" data-uk-icon="icon: instagram; ratio: 0.8"
                            class="uk-icon-button instagram" target="_blank"></a>
                    </div>
                    <div>
                        <a href="https://www.x.com/" data-uk-icon="icon: twitter; ratio: 0.8"
                            class="uk-icon-button twitter" target="_blank"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-child-width-1-2@s uk-child-width-1-4@m" data-uk-grid>
            <div>
                <ul class="uk-list uk-text-small">
                    <li class="uk-active"><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('articles') }}">Article</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div>
                <div><h1>
                    <p class="mb-4">Free Recipes</p>
                    </h1>

                </div>
                <ul class="uk-list uk-text-small">
                    <li><a href="{{ route('recipes.cuisine', 'japanese') }}">Japanese Food</a></li>
                    <li><a href="{{ route('recipes.cuisine', 'indonesia') }}">Indonesian Food</a>
                    <li><a href="{{ route('recipes.cuisine', 'korean') }}">Korean Food</a></li>
                    <li><a href="{{ route('recipes.cuisine', 'indian') }}">Indian Food</a></li>
                    <li><a href="{{ route('recipes.cuisine', 'western') }}">Western Food</a></li>
                    <li><a href="{{ route('recipes.cuisine', 'Italia') }}">Italian Food</a></li>
                </ul>
            </div>
            <div>
                <div>
                    <h1>
                    <p class="mb-4">Premium Recipes</p>
                    </h1>
                </div>
                <ul class="uk-list uk-text-small">
                    <li><a href="{{ route('recipes.premium', 'japanese') }}">Japanese Food</a></li>
                    <li><a href="{{ route('recipes.premium', 'Indonesia') }}">Indonesian Food</a></li>
                    <li><a href="{{ route('recipes.premium', 'korean') }}">Korean Food</a></li>
                    <li><a href="{{ route('recipes.premium', 'indian') }}">Indian Food</a></li>
                    <li><a href="{{ route('recipes.premium', 'western') }}">Western Food</a></li>
                    <li><a href="{{ route('recipes.premium', 'italia') }}">Italian Food</a></li>
                </ul>
            </div>
            <div>
                <ul class="uk-list uk-text-small">
                    <li><a class="uk-link-text" href="#">Contact Form</a></li>
                    <li><a class="uk-link-text" href="#">Work With Us</a></li>
                    <li><a class="uk-link-text" href="#">Visit Us</a></li>
                </ul>
            </div>
        </div>
        <div class="uk-margin-medium-top uk-text-small uk-text-muted">
            <div>Made by a <a class="uk-link-muted" href="" >Cuisine</a></div>
        </div>
    </div>
</footer>
