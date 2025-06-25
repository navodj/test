function toggleTab(tabId) {
    const tab = document.getElementById(tabId);
    tab.classList.toggle('active');

    const activeTabs = document.querySelectorAll('.tab-content.active');
    if (activeTabs.length > 1) {
        document.querySelector('.tab-container').style.flexDirection = 'row';
    } else {
        document.querySelector('.tab-container').style.flexDirection = 'column';
    }
}

