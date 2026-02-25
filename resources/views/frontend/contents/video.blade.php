<section class="video-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-4">
                <h2 class="section-title">{{ $videos->title ?? 'Featured Video' }}</h2>
                <p class="section-subtitle">{{ $videos->subtitle ?? 'Watch our latest content' }}</p>
            </div>
            <div class="col-lg-10">
                <div class="video-wrapper" id="videoWrapper">
                    <!-- Initial thumbnail view -->
                    <div class="thumbnail-container" id="thumbnailContainer">
                        <img src="{{ asset('storage/public/video/' . optional($videos)->thumbnail ?? 'no-thumbnail.jpg') }}" 
                             alt="Video Thumbnail" class="video-thumbnail">
                        <div class="video-overlay" id="videoOverlay">
                            <button class="play-button" onclick="playVideoManually()">
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                        <!-- Loading indicator -->
                        <div class="loading-indicator" id="loadingIndicator">
                            <div class="loading-spinner"></div>
                            <div>Loading video...</div>
                        </div>
                    </div>

                    <!-- YouTube iframe (hidden initially) -->
                    <div class="video-container" id="videoContainer">
                        <iframe id="videoFrame" src="" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('ecomcss')
<style>
    .video-section {
        padding: 60px 0;
    }

    .video-wrapper {
        position: relative;
        width: 100%;
        max-width: 1280px;
        margin: 0 auto;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
    }

    .thumbnail-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transition: opacity 0.5s ease;
        z-index: 2;
    }

    .video-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        transition: opacity 0.3s ease;
    }

    .video-overlay.fade-out {
        opacity: 0;
        pointer-events: none;
    }

    .play-button {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #fff;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .play-button:hover {
        transform: scale(1.1);
    }

    .play-button i {
        font-size: 30px;
        color: #C54B8C;
        margin-left: 5px;
    }

    .video-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.5s ease, visibility 0.5s ease;
        z-index: 1;
    }

    .video-container.active {
        opacity: 1;
        visibility: visible;
        z-index: 3;
    }

    .video-container iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }

    /* Loading indicator */
    .loading-indicator {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 18px;
        display: none;
        text-align: center;
        z-index: 10;
        background: rgba(0, 0, 0, 0.7);
        padding: 20px;
        border-radius: 10px;
    }

    .loading-spinner {
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top: 3px solid white;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin: 0 auto 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Animation when video section comes into view */
    .video-wrapper.animate-in {
        animation: slideInUp 0.8s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .section-title {
            font-size: 15px;
            font-family:'poppins' sans-serif;
        }

        .play-button {
            width: 60px;
            height: 60px;
        }

        .play-button i {
            font-size: 24px;
        }
    }
</style>
@endpush

@push('ecomjs')
<script>
    // Simple and clean configuration
    const AUTO_PLAY_CONFIG = {
        videoUrl: '{{ isset($videos) && $videos->video_url ? $videos->video_url : "" }}',
        autoPlayEnabled: true,
        viewportThreshold: 0.6, // 60% of video must be visible
        playOnce: true
    };

    let hasPlayed = false;
    let observer = null;

    // Convert YouTube URL to embed URL
    function getEmbedUrl(url, autoplay = false) {
        if (!url) return '';
        
        let videoId = '';
        
        // Extract video ID from different YouTube URL formats
        if (url.includes('youtube.com/watch?v=')) {
            videoId = url.split('v=')[1].split('&')[0];
        } else if (url.includes('youtu.be/')) {
            videoId = url.split('youtu.be/')[1].split('?')[0];
        } else if (url.includes('youtube.com/embed/')) {
            videoId = url.split('embed/')[1].split('?')[0];
        }

        if (!videoId) return '';

        // Build embed URL with parameters
        const params = [
            'enablejsapi=1',
            'rel=0',
            'modestbranding=1'
        ];

        if (autoplay) {
            params.push('autoplay=1', 'mute=1');
        }

        return `https://www.youtube.com/embed/${videoId}?${params.join('&')}`;
    }

    // Play video function
    function startVideo(autoplay = false) {
        const thumbnailContainer = document.getElementById('thumbnailContainer');
        const videoContainer = document.getElementById('videoContainer');
        const videoFrame = document.getElementById('videoFrame');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const videoOverlay = document.getElementById('videoOverlay');

        if (!AUTO_PLAY_CONFIG.videoUrl) {
            console.warn('No video URL configured');
            return;
        }

        // Show loading indicator for autoplay
        if (autoplay) {
            loadingIndicator.style.display = 'block';
            videoOverlay.classList.add('fade-out');
        }

        // Set video source
        const embedUrl = getEmbedUrl(AUTO_PLAY_CONFIG.videoUrl, autoplay);
        videoFrame.src = embedUrl;

        // Handle video load
        videoFrame.onload = function() {
    // Show video immediately
    thumbnailContainer.style.opacity = '0';
    videoContainer.classList.add('active');
    loadingIndicator.style.display = 'none';

    hasPlayed = true;
    if (observer) observer.disconnect();
};

    }

    // Manual play (button click)
    function playVideoManually() {
        startVideo(false);
    }

    // Auto play on scroll
    function setupAutoPlay() {
        if (!AUTO_PLAY_CONFIG.autoPlayEnabled || !AUTO_PLAY_CONFIG.videoUrl) {
            return;
        }

        const videoWrapper = document.getElementById('videoWrapper');
        if (!videoWrapper) return;

        // Create intersection observer
        observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && !hasPlayed) {
                    // Add entrance animation
                    videoWrapper.classList.add('animate-in');
                    
                    // Auto-play after short delay
                    setTimeout(() => {
                        if (!hasPlayed && AUTO_PLAY_CONFIG.playOnce) {
                            startVideo(true);
                        }
                    }, 500);
                }
            });
        }, {
            threshold: AUTO_PLAY_CONFIG.viewportThreshold,
            rootMargin: '0px 0px -50px 0px'
        });

        observer.observe(videoWrapper);
    }

    // Initialize everything when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        setupAutoPlay();
    });

    // Legacy function name for backward compatibility
    function playVideo(videoUrl) {
        if (typeof videoUrl === 'string' && videoUrl) {
            AUTO_PLAY_CONFIG.videoUrl = videoUrl;
        }
        playVideoManually();
    }
</script>
@endpush