$(function(){
    $.get('/app.php/getDateTimeStrings', function(dateTimeStrings) {
        var dateTime;

        $.each(dateTimeStrings, function(timeZone, dateTimeString) {
            dateTime = new Date(dateTimeString);

            $("<div></div>").appendTo(".clocks").clock({
                "timestamp": dateTime.getTime(),
                "format": 24
            }).wrap("<p>" + timeZone + "</p>");
        });
    }, "json");
});
