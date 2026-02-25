<!-- Add to your loader component file -->
<div id="ldrsLoader" class="page-loader">
    <div class="loader-content">
        <div class="spinner-logo">
            <!-- Replace with your actual logo -->
            <img src="{{ asset('storage/' . $settings->logo) }}" alt="Loading..." class="logo-spin">
        </div>
        <div class="loader-text">Loading...</div>
    </div>
</div>

<style>
    /* Modern Logo Spinner Loader */
.page-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 99999;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

.page-loader.hide {
    opacity: 0;
    visibility: hidden;
}

.loader-content {
    text-align: center;
}

.spinner-logo {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
}

.logo-spin {
    width: 100%;
    height: 100%;
    object-fit: contain;
    animation: logoRotate 2s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
    filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));
}

.spinner-logo::before {
    content: '';
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    border: 3px solid transparent;
    border-top-color: #4F0808;
    border-radius: 50%;
    animation: spinBorder 1.5s linear infinite;
}

.loader-text {
    font-family: "AloveraDisplay", sans-serif;
    font-size: 18px;
    font-weight: 600;
    color: #4F0808;
    letter-spacing: 2px;
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes logoRotate {
    0%, 100% { transform: rotate(0deg) scale(1); }
    50% { transform: rotate(180deg) scale(1.1); }
}

@keyframes spinBorder {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

@media (max-width: 768px) {
    .spinner-logo, .circle-loader, .shopping-loader {
        width: 80px;
        height: 80px;
    }
    
    .loader-text {
        font-size: 14px;
    }
    
    .logo-spin {
        width: 60px;
        height: 60px;
    }
}
</style>