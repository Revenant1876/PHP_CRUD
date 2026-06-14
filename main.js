const notificationElement = document.getElementById('pageNotification');
const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
const toggleSelectionModeBtn = document.getElementById('toggleSelectionModeBtn');
const selectionHint = document.getElementById('selectionHint');
const studentTable = document.getElementById('studentTable');
const confirmDialog = document.getElementById('confirmDialog');
const confirmButton = document.getElementById('confirmButton');
const dialogMessage = document.getElementById('dialogMessage');
const bulkDeleteForm = document.getElementById('bulkDeleteForm');
let pendingAction = null;
let selectionMode = false;

function setSelectionMode(active) {
    selectionMode = active;
    if (studentTable) {
        studentTable.classList.toggle('selection-active', active);
    }
    if (toggleSelectionModeBtn) {
        toggleSelectionModeBtn.textContent = active ? 'Cancel selection' : 'Select Items';
    }
    if (bulkDeleteBtn) {
        bulkDeleteBtn.classList.toggle('hidden', !active);
        bulkDeleteBtn.disabled = !active || !getRowCheckboxes().some((checkbox) => checkbox.checked);
    }
    if (selectionHint) {
        selectionHint.classList.toggle('hidden', !active);
    }
    if (!active) {
        getRowCheckboxes().forEach((checkbox) => checkbox.checked = false);
        const selectAllBox = document.getElementById('selectAll');
        if (selectAllBox) {
            selectAllBox.checked = false;
        }
    }
}

function toggleSelectionMode() {
    setSelectionMode(!selectionMode);
}

function dismissNotification() {
    if (notificationElement) {
        notificationElement.style.opacity = '0';
        notificationElement.style.transition = 'opacity 0.25s ease-out';
        setTimeout(() => notificationElement.remove(), 250);
    }
}

function getRowCheckboxes() {
    return Array.from(document.querySelectorAll('.row-checkbox'));
}

function updateBulkButton() {
    const anyChecked = getRowCheckboxes().some((checkbox) => checkbox.checked);
    if (bulkDeleteBtn) {
        bulkDeleteBtn.disabled = !anyChecked;
    }
}

function toggleSelectAll(source) {
    getRowCheckboxes().forEach((checkbox) => {
        checkbox.checked = source.checked;
    });
    updateBulkButton();
}

function showDialog(message, onConfirm) {
    if (!confirmDialog || !confirmButton) return;
    dialogMessage.textContent = message;
    pendingAction = onConfirm;
    confirmButton.disabled = false;
    confirmButton.textContent = onConfirm ? 'Delete' : 'Ok';
    confirmDialog.classList.remove('hidden');
    confirmDialog.setAttribute('aria-hidden', 'false');
}

function hideDialog() {
    if (!confirmDialog) return;
    confirmDialog.classList.add('hidden');
    confirmDialog.setAttribute('aria-hidden', 'true');
    pendingAction = null;
}

function confirmDelete(url) {
    showDialog('Are you sure you want to delete this student? This action cannot be undone.', () => {
        window.location.href = url;
    });
}

function confirmBulkDelete() {
    const selectedCount = getRowCheckboxes().filter((checkbox) => checkbox.checked).length;
    if (selectedCount === 0) {
        showDialog('Please select at least one student to delete.', null);
        return;
    }

    showDialog(`Delete ${selectedCount} selected student${selectedCount > 1 ? 's' : ''}? This action cannot be undone.`, () => {
        if (bulkDeleteForm) {
            bulkDeleteForm.submit();
        }
    });
}

if (confirmButton) {
    confirmButton.addEventListener('click', () => {
        if (pendingAction) {
            pendingAction();
        }
        hideDialog();
    });
}

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        hideDialog();
    }
});

// Automatically dismiss the notification after a few seconds.
if (notificationElement) {
    setTimeout(dismissNotification, 4500);
}
