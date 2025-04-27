@extends('layouts.layoutpages')

@section('title', 'About Us')

@section('content')
    <div class="uk-section uk-section-default">
        <div class="uk-container">
            <div class="uk-grid uk-grid-large" data-uk-grid>
                <!-- Left Side Content -->
                <div class="uk-width-1-2@m">
                    <h2 class="uk-heading-medium uk-margin-remove-top">Hello, what's on your mind?</h2>

                    <p class="uk-text-muted uk-margin-medium-top">
                        Credibly administrate market positioning deliverables rather than
                        clicks-and-mortar methodologies. Proactively formulate out-of-the-
                        box technology with clicks-and-mortar testing procedures. Uniquely
                        promote leveraged web-readiness for standards compliant value.
                        Rapidiously pontificate cooperative mindshare via maintainable
                        applications.
                    </p>

                    <div class="uk-margin-medium-top">
                        <a href="#"
                            class="uk-button uk-button-primary uk-border-pill uk-padding-small uk-padding-remove-vertical">
                            Schedule a call
                        </a>
                    </div>

                    {{-- <div class="uk-margin-medium-top">
                        <img src="{{ asset('images/cuisine-logo.png') }}" alt="Cuisine" width="120">
                    </div> --}}
                </div>

                <!-- Right Side Form -->
                <div class="uk-width-1-2@m">
                    <div class="uk-card uk-card-default uk-card-body uk-border-rounded" style="background-color: #f44336;">
                        <form method="POST" action="">
                        {{-- {{ route('about') }} --}}
                            @csrf

                            <div class="uk-margin">
                                <label class="uk-form-label uk-text-white" for="name">Name</label>
                                <div class="uk-form-controls">
                                    <input class="uk-input uk-border-pill" id="name" name="name" type="text"
                                        required>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label uk-text-white" for="email">Email</label>
                                <div class="uk-form-controls">
                                    <input class="uk-input uk-border-pill" id="email" name="email" type="email"
                                        required>
                                </div>
                            </div>

                            <div class="uk-margin">
                                <label class="uk-form-label uk-text-white" for="message">Message</label>
                                <div class="uk-form-controls">
                                    <textarea class="uk-textarea uk-border-rounded" id="message" name="message" rows="6" required></textarea>
                                </div>
                            </div>

                            <div class="uk-margin uk-text-center">
                                <button type="submit"
                                    class="uk-button uk-button-default uk-border-pill uk-background-white">
                                    Kirim Pesan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
