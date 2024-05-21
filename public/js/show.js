document.addEventListener('DOMContentLoaded', function () {
    const carousel = $('#carouselExampleIndicators');

    document.getElementById('prevBtn').addEventListener('click', function () {
        carousel.carousel('prev');
    });

    document.getElementById('nextBtn').addEventListener('click', function () {
        carousel.carousel('next');
    });
});

function addToGoogleCalendar(eventDate, eventTime, eventName, eventDescription, eventLocation) {
    // Convert date from DD/MM/YYYY to YYYY-MM-DD
    const [day, month, year] = eventDate.split('/');
    const formattedDate = `${year}-${month}-${day}`;
    const eventDateTimeString = `${formattedDate}T${eventTime}:00`;
    
    const eventDateTime = new Date(eventDateTimeString);
    if (isNaN(eventDateTime.getTime())) {
        alert('Data ou hora inválida fornecida');
        return;
    }

    const startDateTime = eventDateTime.toISOString().replace(/-|:|\.\d\d\d/g, "");
    const endDateTime = new Date(eventDateTime.getTime() + 60 * 60 * 1000).toISOString().replace(/-|:|\.\d\d\d/g, "");

    const googleCalendarUrl = `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventName)}&dates=${startDateTime}/${endDateTime}&details=${encodeURIComponent(eventDescription)}&location=${encodeURIComponent(eventLocation)}&sf=true&output=xml`;

    window.open(googleCalendarUrl, '_blank');
}