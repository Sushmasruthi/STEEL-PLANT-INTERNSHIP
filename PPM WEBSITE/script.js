document.getElementById('dateShopForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const shopCode = document.getElementById('shopCode').value;

    if (new Date(startDate) > new Date(endDate)) {
        alert('Start date cannot be after end date.');
        return;
    }

    console.log('Start Date:', startDate);
    console.log('End Date:', endDate);
    console.log('Shop Code:', shopCode);

    // You can add your form submission logic here, e.g., send the data to a server
});
