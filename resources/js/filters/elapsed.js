export default (value) => {
    // console.log(value);
    // return value;
    value = new Date(value)
    // console.log(value);
    var timeNow = new Date().getTime(),
        difference = timeNow - value.getTime(),
        seconds = Math.floor(difference / 1000),
        minutes = Math.floor(seconds / 60),
        hours = Math.floor(minutes / 60),
        days = Math.floor(hours / 24);
    if (days > 1) {
        return days + " days ago";
    } else if (days === 1) {
        return "1 day ago";
    } else if (hours > 1) {
        return hours + " hours ago";
    } else if (hours === 1) {
        return "an hour ago";
    } else if (minutes > 1) {
        return minutes + " min ago";
    } else if (minutes === 1) {
        return "a min ago";
    } else {
        return "a few sec ago";
    }
}
