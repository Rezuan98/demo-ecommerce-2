@inject('popup', 'App\Models\Popup')
@php
$activePopup = $popup::getActivePopup();
@endphp

@if($activePopup)
<!-- Dynamic Welcome Popup with Effects -->
<div id="welcomePopup" class="popup-overlay">
    <div class="popup-content" onclick="redirectToOffer()">
        <button class="popup-close" onclick="event.stopPropagation(); closePopup()">&times;</button>
        <div class="popup-glow"></div>
        <div class="popup-sparkles">
            <div class="sparkle sparkle-1">✨</div>
            <div class="sparkle sparkle-2">💫</div>
            <div class="sparkle sparkle-3">⭐</div>
            <div class="sparkle sparkle-4">✨</div>
        </div>
        <img src="{{ asset('uploads/popups/' . $activePopup->image) }}" alt="Welcome Offer" class="popup-image">
        <div class="click-hint">Click to Shop Now!</div>
    </div>
</div>

@push('ecomcss')
<style>
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    display: none;
    animation: fadeIn 0.5s ease-in-out;
}

.popup-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 12px;
    max-width: 500px;
    width: 90%;
    margin: 0 auto;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    animation: popupBounce 0.6s ease-out, glowPulse 2s infinite;
    border: 3px solid transparent;
    background-clip: padding-box;
    cursor: pointer;
    transition: transform 0.3s ease;
}

/* Glowing border effect */
.popup-content::before {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ffa726, #ff6b6b);
    background-size: 400% 400%;
    border-radius: 15px;
    z-index: -1;
    animation: gradientShift 3s ease infinite;
}

/* Glow effect behind popup */
.popup-glow {
    position: absolute;
    top: -20px;
    left: -20px;
    right: -20px;
    bottom: -20px;
    background: radial-gradient(circle, rgba(255, 107, 107, 0.3) 0%, transparent 70%);
    border-radius: 50px;
    z-index: -2;
    animation: glowPulse 2s infinite alternate;
}

.popup-close {
    position: absolute;
    top: 5px;
    right: 8px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    font-size: 24px;
    cursor: pointer;
    z-index: 10;
    color: #666;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    animation: buttonPulse 2s infinite;
}

.popup-close:hover {
    color: #000;
    background: rgba(255, 255, 255, 1);
    transform: scale(1.1);
}

.popup-image {
    width: 100%;
    height: auto;
    display: block;
    animation: imagePulse 3s infinite;
    pointer-events: none;
}

/* Click hint */
.click-hint {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(255, 107, 107, 0.9);
    color: white;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: bold;
    animation: clickHintBlink 1.5s infinite;
    pointer-events: none;
}

.popup-content:hover {
    transform: translate(-50%, -50%) scale(1.02);
}

.popup-content:hover .click-hint {
    animation: clickHintBlink 0.5s infinite;
}

/* Sparkle effects */
.popup-sparkles {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    z-index: 5;
}

.sparkle {
    position: absolute;
    font-size: 20px;
    animation: sparkleFloat 3s infinite;
}

.sparkle-1 {
    top: 15%;
    left: 10%;
    animation-delay: 0s;
}

.sparkle-2 {
    top: 25%;
    right: 15%;
    animation-delay: 0.5s;
}

.sparkle-3 {
    bottom: 20%;
    left: 15%;
    animation-delay: 1s;
}

.sparkle-4 {
    bottom: 30%;
    right: 10%;
    animation-delay: 1.5s;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes popupBounce {
    0% { 
        transform: translate(-50%, -50%) scale(0.5);
        opacity: 0;
    }
    50% { 
        transform: translate(-50%, -50%) scale(1.05);
    }
    100% { 
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }
}

@keyframes glowPulse {
    0%, 100% { 
        box-shadow: 0 15px 35px rgba(0,0,0,0.2), 0 0 20px rgba(255, 107, 107, 0.3);
    }
    50% { 
        box-shadow: 0 15px 35px rgba(0,0,0,0.3), 0 0 30px rgba(255, 107, 107, 0.6);
    }
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes buttonPulse {
    0%, 100% { 
        box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.4);
    }
    50% { 
        box-shadow: 0 0 0 10px rgba(255, 107, 107, 0);
    }
}

@keyframes imagePulse {
    0%, 100% { 
        filter: brightness(1) contrast(1);
    }
    50% { 
        filter: brightness(1.1) contrast(1.1);
    }
}

@keyframes sparkleFloat {
    0%, 100% { 
        transform: translateY(0px) rotate(0deg);
        opacity: 0.7;
    }
    25% { 
        transform: translateY(-10px) rotate(90deg);
        opacity: 1;
    }
    50% { 
        transform: translateY(-5px) rotate(180deg);
        opacity: 0.8;
    }
    75% { 
        transform: translateY(-15px) rotate(270deg);
        opacity: 1;
    }
}

/* Blinking text effect for offers */
.popup-content::after {
    content: '🎉 LIMITED TIME OFFER 🎉';
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    animation: blinkOffer 1s infinite, moveUpDown 2s infinite;
    white-space: nowrap;
}

@keyframes blinkOffer {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.3; }
}

@keyframes moveUpDown {
    0%, 100% { transform: translateX(-50%) translateY(0px); }
    50% { transform: translateX(-50%) translateY(-5px); }
}

@keyframes clickHintBlink {
    0%, 100% { 
        opacity: 1;
        transform: translateX(-50%) scale(1);
    }
    50% { 
        opacity: 0.6;
        transform: translateX(-50%) scale(1.1);
    }
}

/* Mobile responsive */
@media (max-width: 576px) {
    .popup-overlay {
        padding: 20px;
        box-sizing: border-box;
    }
    
    .popup-content {
        max-width: none;
        width: calc(100% - 40px);
        margin: 0 20px;
        left: 50%;
        transform: translate(-50%, -50%);
        position: fixed;
    }
    
    .sparkle {
        font-size: 16px;
    }
    
    .popup-content::after {
        font-size: 10px;
        bottom: -25px;
    }
    
    .click-hint {
        font-size: 11px;
        padding: 4px 10px;
    }
}
</style>
@endpush

@push('ecomjs')
<script>
function showPopup() {
    const now = Date.now();
    const lastShown = localStorage.getItem('popupLastShown');
    const popupCount = parseInt(localStorage.getItem('popupCount') || '0');
    
    const ONE_HOUR = 60 * 60 * 1000;
    const ONE_DAY = 24 * 60 * 60 * 1000;
    
    let shouldShow = false;
    let delay = 2000;
    
    if (!lastShown) {
        shouldShow = true;
        delay = 1000;
    } else {
        const timeSinceLastShown = now - parseInt(lastShown);
        
        if (popupCount <= 2) {
            if (timeSinceLastShown > ONE_HOUR) {
                shouldShow = true;
                delay = 3000;
            }
        } else if (popupCount <= 5) {
            if (timeSinceLastShown > (4 * ONE_HOUR)) {
                shouldShow = true;
                delay = 5000;
            }
        } else {
            if (timeSinceLastShown > ONE_DAY) {
                shouldShow = true;
                delay = 7000;
            }
        }
    }
    
    if (shouldShow) {
        setTimeout(() => {
            document.getElementById('welcomePopup').style.display = 'block';
            localStorage.setItem('popupLastShown', now.toString());
            localStorage.setItem('popupCount', (popupCount + 1).toString());
            
            document.body.style.animation = 'screenShake 0.5s ease-in-out';
            setTimeout(() => {
                document.body.style.animation = '';
            }, 500);
        }, delay);
    }
}

function closePopup() {
    const popup = document.getElementById('welcomePopup');
    popup.style.animation = 'fadeOut 0.3s ease-in-out';
    setTimeout(() => {
        popup.style.display = 'none';
        popup.style.animation = '';
    }, 300);
}

function redirectToOffer() {
    // Get the dynamic link from the active popup
    const offerUrl = '{{ $activePopup->link ?? route("home") }}';
    if (offerUrl) {
        window.location.href = offerUrl;
    }
}

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Show popup after 2 seconds
    setTimeout(showPopup, 2000);
    
    // Add click outside to close functionality
    const popupOverlay = document.getElementById('welcomePopup');
    if (popupOverlay) {
        popupOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closePopup();
            }
        });
    }
});

// Add screen shake animation to CSS
const shakeStyle = document.createElement('style');
shakeStyle.textContent = `
    @keyframes screenShake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-2px); }
        75% { transform: translateX(2px); }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
document.head.appendChild(shakeStyle);
</script>
@endpush
@endif