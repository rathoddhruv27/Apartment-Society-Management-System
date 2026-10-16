{{-- =============================================
     MODAL BLADE COMPONENT
     resources/views/components/modal.blade.php

     Usage:
       <x-modal id="my-modal" title="Modal Title">
           <form id="my-form" action="..." method="POST">
               Form / body content here
           </form>
           <x-slot name="footer">
               <button type="button" onclick="document.getElementById('my-modal').classList.add('hidden')">Cancel</button>
               <button type="submit" form="my-form">Submit</button>
           </x-slot>
       </x-modal>

     Props:
       id        – required, unique HTML id for the overlay div
       title     – modal header title text
       size      – 'md' (default) | 'lg'
       onClose   – JS expression called when close is clicked
                   Defaults to hiding the overlay by id
     ============================================= --}}

@props([
    'id',
    'title'   => '',
    'size'    => 'md',
    'onClose' => null,
])

@php
    $closeAction = $onClose ?? "document.getElementById('{$id}').classList.add('hidden')";
    $sizeClass = $size === 'lg'
        ? 'modal-container modal-container-lg'
        : 'modal-container';
@endphp

<div id="{{ $id }}" class="modal-overlay hidden">
    <div class="{{ $sizeClass }}">

        {{-- Header --}}
        <div class="modal-header">
            <h3 class="modal-title">{{ $title }}</h3>

            <button
                type="button"
                onclick="{{ $closeAction }}"
                class="modal-close-btn"
                aria-label="Close modal"
            >✕</button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            {{ $slot }}
        </div>

        @isset($footer)
            <div class="modal-footer">
                {{ $footer }}
            </div>
        @endisset

    </div>
</div>