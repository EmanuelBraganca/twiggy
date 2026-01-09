@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-gray-700',
    'teleport' => true,
])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};
@endphp

<style>[x-cloak]{display:none!important;}</style>

<div
    x-data="{
        open: false,
        moved: false,
        clickHandler: null,
        resizeHandler: null,
        setPos(){
            if(!this.$refs.trigger || !this.$refs.panel) return;
            const r = this.$refs.trigger.getBoundingClientRect();
            const top = r.bottom + window.scrollY;
            const left = r.left + window.scrollX;
            Object.assign(this.$refs.panel.style, {
                position: 'absolute',
                top: top + 'px',
                left: left + 'px',
                zIndex: '9999'
            });
        },
        moveToBody(){
            if(this.moved || !this.$refs.panel) return;
            document.body.appendChild(this.$refs.panel);
            this.moved = true;
        },
        openToggle(useTeleport){
            this.open = !this.open;
            if(this.open){
                if(useTeleport){
                    this.moveToBody();
                    this.$nextTick(()=> this.setPos());
                    this.clickHandler = (e)=>{
                        if(!this.$refs.panel || !this.$refs.trigger) return;
                        if(this.$refs.panel.contains(e.target) || this.$refs.trigger.contains(e.target)) return;
                        this.open = false;
                    };
                    document.addEventListener('click', this.clickHandler, true);
                    this.resizeHandler = ()=> this.setPos();
                    window.addEventListener('resize', this.resizeHandler);
                    window.addEventListener('scroll', this.resizeHandler, true);
                }
            } else {
                if(this.clickHandler) document.removeEventListener('click', this.clickHandler, true);
                if(this.resizeHandler) window.removeEventListener('resize', this.resizeHandler);
                if(this.resizeHandler) window.removeEventListener('scroll', this.resizeHandler, true);
            }
        }
    }"
    class="relative z-50"
    @close.stop="open = false"
>
    <div x-ref="trigger" @click.stop="openToggle({{ $teleport ? 'true' : 'false' }})">
        {{ $trigger }}
    </div>
    <div x-ref="panel"
            x-show="open"
            x-cloak
            @click.away.stop="open = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }} @if(! $teleport) absolute @endif"
            >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
