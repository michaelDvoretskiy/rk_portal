Date.prototype.dmyFormat = function() {
    var d = new Date();
    var day = this.getDate();
    if (day < 10) {
        day = "0" + day;
    }
    var month = this.getMonth() + 1;
    if (month < 10) {
        month = "0" + month;
    }
    var year = this.getFullYear();
    return day + "." + month + "." + year;
}

Date.prototype.myMonthBeg = function() {
    return new Date( this.getFullYear(), this.getMonth(), 1 );
}

Date.prototype.myMonthEnd = function() {
    return new Date( this.getFullYear(), this.getMonth() + 1, 0);
}