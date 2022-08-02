@extends('web.layouts.app')

@section('content')
    <section class="section faq-section faq-section_v2 pd-tb100">
        <div class="container">

            <div class="faq-accordion-content-main">
                <div id="accordion">
                    @forelse($faqs as $faq)
                    @include('web.common.faq', ['faq' => $faq, 'loop' => $loop])
                    @empty
                        @include('web.common.not-found', ['message' => 'No Faqs found'])
                        @endforelse
                    {!! $faqs->onEachSide(0)->links() !!}
                </div>
            </div>
        </div>

    </section>

@endsection
