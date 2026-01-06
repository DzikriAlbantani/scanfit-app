<!DOCTYPE html>
<html>
<head>
    <title>Subscription Status Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .status {
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 15px 0;
        }
        .success {
            background: #f0fdf4;
            border-left-color: #10b981;
        }
        .error {
            background: #fef2f2;
            border-left-color: #ef4444;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .value {
            color: #333;
            font-size: 18px;
        }
        button {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        button:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>🔍 Subscription Status Test</h1>
        
        <div class="status success">
            <div class="label">✅ Database Status (Verified)</div>
            <div class="value">Payment: PAID | Plan: PLUS | Premium: TRUE</div>
        </div>
        
        <div class="status">
            <div class="label">User ID</div>
            <div class="value" id="user-id">Loading...</div>
        </div>
        
        <div class="status">
            <div class="label">Subscription Plan</div>
            <div class="value" id="plan">Loading...</div>
        </div>
        
        <div class="status">
            <div class="label">is_premium</div>
            <div class="value" id="is-premium">Loading...</div>
        </div>
        
        <div class="status">
            <div class="label">isPremium() Method</div>
            <div class="value" id="is-premium-method">Loading...</div>
        </div>
        
        <div class="status">
            <div class="label">Expires At</div>
            <div class="value" id="expires-at">Loading...</div>
        </div>
        
        <button onclick="window.location.href='/scan'">Go to Scan Page →</button>
        <button onclick="window.location.href='/profile'">Go to Profile →</button>
    </div>
    
    <script>
        fetch('/test-subscription')
            .then(res => res.json())
            .then(data => {
                document.getElementById('user-id').textContent = data.user_id + ' - ' + data.name;
                document.getElementById('plan').textContent = data.subscription_plan;
                document.getElementById('is-premium').textContent = data.is_premium;
                document.getElementById('is-premium-method').textContent = data['isPremium()'];
                document.getElementById('expires-at').textContent = data.subscription_expires_at;
                
                // Update status colors
                if (data['isPremium()'] === 'TRUE') {
                    document.querySelectorAll('.status').forEach(el => {
                        if (!el.classList.contains('success')) {
                            el.classList.add('success');
                        }
                    });
                }
            })
            .catch(err => {
                console.error(err);
                document.querySelectorAll('.value').forEach(el => {
                    el.textContent = 'Error loading data';
                });
            });
    </script>
</body>
</html>
