const places = Array.from(document.querySelectorAll('.parking_box__place'));

places.forEach(place => place.addEventListener('click', () => {
    window.location.href = `/reservations/new?no=${place.id}`;
}))