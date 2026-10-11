@extends('layouts.main')

@section('title', 'Terms of Service — RACAi Discipleship')

@section('content')
        <!-- breadcrumb -->
        @include('layouts.breadcrumb', ['pageTitle' => 'Terms Of Service'])
         
        <!-- terms-policy-section -->
        <div class="terms-policy-section p-tb-100">
            <div class="container">
                <div class="text-details-content desk-pad-left-40 desk-pad-right-40">
                    <img src="{{ asset('assets/images/terms-policy-image-1.jpg') }}" alt="terms">
                    <p>This Terms of Service contents was last updated on January 1, 2026.</p>
                    <h3>Definitions of Basic Terms, Rights & Restriction:</h3>
                    <p>Dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est sit amet luptatem. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit,</p>
                    <p>Visit Platform: <a href="{{ url('/') }}">{{ url('/') }}</a></p>
                    <h3>Required Terms</h3>
                    <p>Eriam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, <a href="#">(*RACAi Discipleship Portal)</a> um quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora <a href="#">(Available globally for all believers)</a> lore magnam aliquam quaerat voluptatem.</p>
                    <h3>Legal Rights & Restrictions</h3>
                    <p>Eriam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est</p>
                    <h3>Our Policy Concerning Under 18 </h3>
                    <p>Children under 13 (or under 16 in the USA) cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam </p>
                </div>
            </div>
        </div>
        <!-- .end terms-policy-section -->
        
@endsection