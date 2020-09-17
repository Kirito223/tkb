import axiosClient from "./axiosClient.js";

export function layDulieu() {
    const url = "xeptbk/dulieu";
    return axiosClient.get(url);
}
// export function taoThoikhoabieuTam(kho, lophoc) {
//     let lophoc = kho.lophoc;

//     // chon tim lop hoc da chon

//     let chimucLop = lophoc.findIndex(x=>x.id == lophoc);

//     // Chon lop

//     let chonlop = lophoc[chimucLop];

//     console.log(chonlop);

// }