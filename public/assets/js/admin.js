function openReportModal(reportId, btn) {
    document.getElementById('reportId').value = reportId;

    // populate modal fields from button data attributes
    if (btn) {
        var reporter = btn.getAttribute('data-reporter') || '';
        var targetLabel = btn.getAttribute('data-target-label') || '';
        var targetLink = btn.getAttribute('data-target-link') || '#';
        var reason = btn.getAttribute('data-reason') || '';
        var status = btn.getAttribute('data-status') || 'pending';

        document.getElementById('modalReporter').textContent = reporter;
        document.getElementById('modalTargetLabel').textContent = targetLabel;
        var tlink = document.getElementById('modalTargetLink');
        tlink.href = targetLink;
        document.getElementById('modalReason').textContent = reason;
        document.getElementById('reportStatus').value = status;
    }

    document.getElementById('reportModal').style.display = 'flex';
}

function closeReportModal() {
    document.getElementById('reportModal').style.display = 'none';
}