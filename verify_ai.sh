#!/bin/bash

# QUICK VERIFICATION TEST FOR GEMINI AI
# Usage: bash verify_ai.sh

echo "🤖 GEMINI AI DETECTION VERIFICATION"
echo "===================================="
echo ""

cd "$(dirname "$0")" || exit

# Check if .env has API key
echo "✅ Step 1: Checking API Key..."
if grep -q "GOOGLE_AI_API_KEY=" .env; then
    echo "   ✓ API Key found in .env"
else
    echo "   ✗ API Key NOT found in .env"
    echo "   Add: GOOGLE_AI_API_KEY=your_key_here"
    exit 1
fi

echo ""

# Check if scan images exist
echo "✅ Step 2: Checking for scan images..."
if [ -d "storage/app/public/scans" ]; then
    count=$(find storage/app/public/scans -type f | wc -l)
    if [ "$count" -gt 0 ]; then
        echo "   ✓ Found $count image(s) in storage/app/public/scans"
    else
        echo "   ✗ No images in storage/app/public/scans/"
        echo "   Upload an outfit image first at: /scan"
        exit 1
    fi
else
    echo "   ✗ Directory storage/app/public/scans not found"
    exit 1
fi

echo ""

# Run PHP test
echo "✅ Step 3: Running Gemini AI test..."
echo ""
php artisan tinker << 'EOF'
include 'tests/verify_gemini_detection.php';
EOF

echo ""
echo "===================================="
echo "Test completed! Check results above."
