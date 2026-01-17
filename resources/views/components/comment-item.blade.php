<div class="single-comment comment-item py-3 border-bottom" 
     data-comment-id="{{ $comment->id }}">
    
    <div class="d-flex">
        <div class="flex-shrink-0 me-3">
            <img src="{{ asset('storage/' . $avatar) }}" 
                 class="rounded-circle" 
                 width="44" height="44" 
                 style="object-fit: cover; border: 1px solid #e9ecef;">
        </div>
        
        <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-3 mb-1">
                <strong style="font-size: 1rem; color: #111;">
                    {{ $comment->user->name ?? 'User' }}
                </strong>
                <span class="text-muted" style="font-size: 0.78rem; font-weight: 400;">
                    • {{ $time }}
                </span>
            </div>
            
            <div style="font-size: 0.98rem; line-height: 1.65; color: #333;">
                {!! nl2br(e($comment->comment)) !!}
            </div>
        </div>
    </div>
</div>