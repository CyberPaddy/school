  // Kiitos https://webdesign.tutsplus.com/tutorials/a-simple-javascript-technique-for-filling-star-ratings--cms-29450

  // Muutetaan arvostelut tähdiksi
  var ratings = document.getElementsByClassName("stars-inner");
  const maxStars = 5;

  for (var i = 0; i < ratings.length; i++) {
    // Tietokannasta haettu arvostelu 0-5
    var rating = ratings[i].textContent;

    var starPercentage = (rating / maxStars) * 90;
    ratings[i].style.width = starPercentage;
  }
