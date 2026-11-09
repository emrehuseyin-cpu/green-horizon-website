#!/usr/bin/env python3
"""
Green Horizon — Local Development Server with Clean URL Routing
Supports extensionless URLs (e.g. /about -> about.html, /gallery -> gallery.html)
"""
import http.server
import socketserver
import os
import sys

PORT = 8000

class CleanURLHandler(http.server.SimpleHTTPRequestHandler):
    def translate_path(self, path):
        # Let parent convert URL path to local filesystem path
        fs_path = super().translate_path(path)
        # If the requested path does not exist, check if appending .html matches a file
        if not os.path.exists(fs_path) and os.path.exists(fs_path + '.html'):
            return fs_path + '.html'
        return fs_path

if __name__ == '__main__':
    port = int(sys.argv[1]) if len(sys.argv) > 1 else PORT
    
    socketserver.TCPServer.allow_reuse_address = True
    
    with socketserver.TCPServer(("", port), CleanURLHandler) as httpd:
        print("=" * 60)
        print("  🌱 Green Horizon Local Development Server")
        print(f"  👉 Open in browser: http://localhost:{port}")
        print("  ⚡ Clean URLs (/about, /activities, /gallery, etc.) enabled")
        print("  🛑 Press Ctrl + C to stop the server")
        print("=" * 60)
        try:
            httpd.serve_forever()
        except KeyboardInterrupt:
            print("\nServer stopped gracefully.")
