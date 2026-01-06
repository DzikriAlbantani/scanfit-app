{{-- Reusable Confirmation Modal Component --}}
<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/50" onclick="closeConfirmModal()"></div>

    {{-- Modal Content --}}
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full animate-in fade-in zoom-in duration-200">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h3 id="modalTitle" class="text-lg font-bold text-slate-900">Confirm Action</h3>
        </div>

        {{-- Body --}}
        <div class="px-6 py-6">
            <div class="flex items-start gap-4">
                <div id="iconContainer" class="flex-shrink-0 w-12 h-12 rounded-full bg-red-50 flex items-center justify-center">
                    <svg id="modalIcon" class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 6a9 9 0 110-18 9 9 0 010 18z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p id="modalMessage" class="text-slate-600 text-sm leading-relaxed">
                        Are you sure you want to perform this action?
                    </p>
                    <p id="modalWarning" class="mt-3 text-xs text-red-600 font-medium hidden">
                        This action cannot be undone.
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex gap-3 justify-end">
            <button onclick="closeConfirmModal()" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition-colors">
                Cancel
            </button>
            <button id="confirmBtn" onclick="confirmAction()" class="px-4 py-2 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition-colors">
                Confirm
            </button>
        </div>
    </div>
</div>

<script>
    // Use window object to ensure global scope accessibility
    window.pendingAction = null;
    window.pendingForm = null;

    /**
     * Open confirmation modal
     * @param {object} options - Configuration object
     *   - title: Modal title
     *   - message: Modal message
     *   - type: 'delete', 'warning', 'success' (affects icon color)
     *   - showWarning: Show "cannot be undone" warning
     *   - onConfirm: Callback function to execute on confirm
     *   - form: Form element to submit (alternative to callback)
     */
    window.openConfirmModal = function(options = {}) {
        const {
            title = 'Confirm Action',
            message = 'Are you sure?',
            type = 'delete',
            showWarning = true,
            onConfirm = null,
            form = null
        } = options;

        const modal = document.getElementById('confirmModal');
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const warningEl = document.getElementById('modalWarning');
        const iconContainer = document.getElementById('iconContainer');
        const modalIcon = document.getElementById('modalIcon');
        const confirmBtn = document.getElementById('confirmBtn');

        // Set content
        titleEl.textContent = title;
        messageEl.textContent = message;

        // Update warning visibility
        if (showWarning) {
            warningEl.classList.remove('hidden');
        } else {
            warningEl.classList.add('hidden');
        }

        // Update icon and colors based on type
        const typeConfig = {
            delete: {
                iconColor: 'text-red-600',
                bgColor: 'bg-red-50',
                btnColor: 'bg-red-600 hover:bg-red-700',
                icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>'
            },
            warning: {
                iconColor: 'text-yellow-600',
                bgColor: 'bg-yellow-50',
                btnColor: 'bg-yellow-600 hover:bg-yellow-700',
                icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 6a9 9 0 110-18 9 9 0 010 18z"></path>'
            },
            success: {
                iconColor: 'text-blue-600',
                bgColor: 'bg-blue-50',
                btnColor: 'bg-blue-600 hover:bg-blue-700',
                icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            }
        };

        const config = typeConfig[type] || typeConfig.delete;
        iconContainer.className = `flex-shrink-0 w-12 h-12 rounded-full ${config.bgColor} flex items-center justify-center`;
        modalIcon.className = `w-6 h-6 ${config.iconColor}`;
        modalIcon.innerHTML = config.icon;
        confirmBtn.className = `px-4 py-2 rounded-lg text-white font-medium transition-colors ${config.btnColor}`;

        // Store callback and form
        window.pendingAction = onConfirm;
        window.pendingForm = form;

        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.closeConfirmModal = function() {
        const modal = document.getElementById('confirmModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        window.pendingAction = null;
        window.pendingForm = null;
    };

    window.confirmAction = function() {
        console.log('confirmAction called');
        console.log('pendingForm:', window.pendingForm);
        console.log('pendingAction:', window.pendingAction);
        
        if (window.pendingForm) {
            // Submit form if provided
            console.log('Submitting form...');
            window.pendingForm.submit();
        } else if (window.pendingAction && typeof window.pendingAction === 'function') {
            // Execute callback if provided
            console.log('Executing callback...');
            window.pendingAction();
        }
        window.closeConfirmModal();
    };

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            window.closeConfirmModal();
        }
    });

    // Utility functions for common actions
    // Expose confirm helpers globally so layouts can use them
    window.showDeleteConfirm = function(itemName, onConfirm, form = null) {
        window.openConfirmModal({
            title: 'Delete ' + itemName,
            message: `Are you sure you want to delete "${itemName}"? This action cannot be undone.`,
            type: 'delete',
            showWarning: true,
            onConfirm: onConfirm,
            form: form
        });
    };

    window.showWarningConfirm = function(title, message, onConfirm, form = null) {
        window.openConfirmModal({
            title: title,
            message: message,
            type: 'warning',
            showWarning: false,
            onConfirm: onConfirm,
            form: form
        });
    };
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-in {
        animation: fadeIn 0.2s ease-out, zoomIn 0.2s ease-out;
    }

    .fade-in {
        animation: fadeIn 0.2s ease-out;
    }

    .zoom-in {
        animation: zoomIn 0.2s ease-out;
    }

    .duration-200 {
        animation-duration: 200ms;
    }
</style>
