export function getFistDay(date) {
    return moment(date, "DD/MM/YYYY").startOf("month").format("YYYY-MM-DD");
}
export function getLastDay(date) {
    return moment(date, "DD/MM/YYYY").endOf("month").format("YYYY-MM-DD");
}
