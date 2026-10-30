/**
 * GREEN HORIZON — 360° Interactive VR Panorama Viewer
 * Pure HTML5 Canvas & WebGL Spherical Projection Engine
 */

class GreenHorizonVRViewer {
  constructor(canvasId, imageSrc, options = {}) {
    this.canvas = document.getElementById(canvasId);
    if (!this.canvas) return;

    this.ctx = this.canvas.getContext('2d');
    this.imageSrc = imageSrc;
    this.options = Object.assign({
      fov: 75,
      minFov: 40,
      maxFov: 100,
      autoRotate: true,
      autoRotateSpeed: 0.15,
      yaw: 0,
      pitch: 0,
      hotspots: [
        { yaw: 45, pitch: 10, label: 'Carpathian Ancient Beech Canopy' },
        { yaw: 180, pitch: -15, label: 'Alluvial Riverbed Hydro Dynamics' },
        { yaw: 270, pitch: 5, label: 'UAV Survey Flight Elevation 120M' }
      ]
    }, options);

    this.isDragging = false;
    this.lastMouseX = 0;
    this.lastMouseY = 0;
    this.targetYaw = this.options.yaw;
    this.targetPitch = this.options.pitch;
    this.currentYaw = this.options.yaw;
    this.currentPitch = this.options.pitch;
    this.currentFov = this.options.fov;

    this.image = new Image();
    this.imageLoaded = false;

    this.init();
  }

  init() {
    this.image.crossOrigin = 'anonymous';
    this.image.onload = () => {
      this.imageLoaded = true;
      this.resize();
      this.render();
    };
    this.image.src = this.imageSrc;

    window.addEventListener('resize', () => this.resize());
    this.setupEvents();
    this.animate();
  }

  resize() {
    if (!this.canvas) return;
    this.canvas.width = this.canvas.clientWidth * (window.devicePixelRatio || 1);
    this.canvas.height = this.canvas.clientHeight * (window.devicePixelRatio || 1);
  }

  setupEvents() {
    const el = this.canvas;

    el.addEventListener('mousedown', (e) => {
      this.isDragging = true;
      this.lastMouseX = e.clientX;
      this.lastMouseY = e.clientY;
    });

    window.addEventListener('mousemove', (e) => {
      if (!this.isDragging) return;
      const dx = e.clientX - this.lastMouseX;
      const dy = e.clientY - this.lastMouseY;
      this.lastMouseX = e.clientX;
      this.lastMouseY = e.clientY;

      this.targetYaw -= dx * 0.25;
      this.targetPitch = Math.max(-60, Math.min(60, this.targetPitch + dy * 0.25));
    });

    window.addEventListener('mouseup', () => {
      this.isDragging = false;
    });

    // Touch Support
    el.addEventListener('touchstart', (e) => {
      if (e.touches.length === 1) {
        this.isDragging = true;
        this.lastMouseX = e.touches[0].clientX;
        this.lastMouseY = e.touches[0].clientY;
      }
    }, { passive: true });

    el.addEventListener('touchmove', (e) => {
      if (this.isDragging && e.touches.length === 1) {
        const dx = e.touches[0].clientX - this.lastMouseX;
        const dy = e.touches[0].clientY - this.lastMouseY;
        this.lastMouseX = e.touches[0].clientX;
        this.lastMouseY = e.touches[0].clientY;

        this.targetYaw -= dx * 0.35;
        this.targetPitch = Math.max(-60, Math.min(60, this.targetPitch + dy * 0.35));
      }
    }, { passive: true });

    el.addEventListener('touchend', () => {
      this.isDragging = false;
    });

    // Mouse wheel zoom
    el.addEventListener('wheel', (e) => {
      e.preventDefault();
      this.currentFov = Math.max(this.options.minFov, Math.min(this.options.maxFov, this.currentFov + e.deltaY * 0.05));
    }, { passive: false });
  }

  animate() {
    requestAnimationFrame(() => this.animate());

    if (this.options.autoRotate && !this.isDragging) {
      this.targetYaw += this.options.autoRotateSpeed;
    }

    // Smooth inertia interpolation
    this.currentYaw += (this.targetYaw - this.currentYaw) * 0.1;
    this.currentPitch += (this.targetPitch - this.currentPitch) * 0.1;

    this.render();
  }

  render() {
    if (!this.imageLoaded || !this.ctx) return;

    const w = this.canvas.width;
    const h = this.canvas.height;
    const ctx = this.ctx;

    ctx.clearRect(0, 0, w, h);

    // Normalize yaw to [0, 360)
    let normalizedYaw = (this.currentYaw % 360 + 360) % 360;
    const imgW = this.image.width;
    const imgH = this.image.height;

    // Map 360 degrees to image width
    const sourceX = (normalizedYaw / 360) * imgW;
    const fovRatio = this.currentFov / 360;
    const sliceWidth = imgW * fovRatio;

    // Pitch offset
    const pitchOffset = (this.currentPitch / 90) * (imgH * 0.25);
    const sourceY = Math.max(0, Math.min(imgH - imgH * 0.6, (imgH * 0.2) + pitchOffset));
    const sliceHeight = imgH * 0.6;

    // Draw wrapped panoramic sections
    if (sourceX + sliceWidth <= imgW) {
      ctx.drawImage(this.image, sourceX, sourceY, sliceWidth, sliceHeight, 0, 0, w, h);
    } else {
      const part1 = imgW - sourceX;
      const part2 = sliceWidth - part1;
      const splitScreenX = (part1 / sliceWidth) * w;

      ctx.drawImage(this.image, sourceX, sourceY, part1, sliceHeight, 0, 0, splitScreenX, h);
      ctx.drawImage(this.image, 0, sourceY, part2, sliceHeight, splitScreenX, 0, w - splitScreenX, h);
    }

    // Draw interactive VR Hotspots
    this.renderHotspots(w, h, normalizedYaw);
  }

  renderHotspots(w, h, normalizedYaw) {
    const ctx = this.ctx;

    this.options.hotspots.forEach(hotspot => {
      let diffYaw = hotspot.yaw - normalizedYaw;
      if (diffYaw > 180) diffYaw -= 360;
      if (diffYaw < -180) diffYaw += 360;

      const fovRange = this.currentFov / 2;
      if (Math.abs(diffYaw) < fovRange) {
        const screenX = ((diffYaw + fovRange) / this.currentFov) * w;
        const screenY = (h / 2) - ((hotspot.pitch - this.currentPitch) * (h / 70));

        // Draw pulsing beacon
        ctx.save();
        ctx.beginPath();
        ctx.arc(screenX, screenY, 14, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(183, 255, 74, 0.25)';
        ctx.fill();
        ctx.strokeStyle = '#B7FF4A';
        ctx.lineWidth = 2;
        ctx.stroke();

        ctx.beginPath();
        ctx.arc(screenX, screenY, 5, 0, Math.PI * 2);
        ctx.fillStyle = '#B7FF4A';
        ctx.fill();

        // Hotspot label
        ctx.font = '600 13px "Space Grotesk", sans-serif';
        const textWidth = ctx.measureText(hotspot.label).width;
        
        ctx.fillStyle = 'rgba(7, 20, 17, 0.85)';
        ctx.roundRect ? ctx.roundRect(screenX - textWidth / 2 - 8, screenY - 32, textWidth + 16, 22, 4) : ctx.rect(screenX - textWidth / 2 - 8, screenY - 32, textWidth + 16, 22);
        ctx.fill();
        ctx.strokeStyle = 'rgba(35, 201, 171, 0.4)';
        ctx.stroke();

        ctx.fillStyle = '#FFFFFF';
        ctx.textAlign = 'center';
        ctx.fillText(hotspot.label, screenX, screenY - 17);
        ctx.restore();
      }
    });
  }

  toggleAutoRotate() {
    this.options.autoRotate = !this.options.autoRotate;
    return this.options.autoRotate;
  }

  zoomIn() {
    this.currentFov = Math.max(this.options.minFov, this.currentFov - 10);
  }

  zoomOut() {
    this.currentFov = Math.min(this.options.maxFov, this.currentFov + 10);
  }

  toggleFullscreen() {
    const wrapper = this.canvas.parentElement;
    if (!document.fullscreenElement) {
      if (wrapper.requestFullscreen) wrapper.requestFullscreen();
    } else {
      if (document.exitFullscreen) document.exitFullscreen();
    }
  }
}

// Global hook for easy instantiation
window.initVRViewer = function(canvasId, imageSrc) {
  return new GreenHorizonVRViewer(canvasId, imageSrc);
};
