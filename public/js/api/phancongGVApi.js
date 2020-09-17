import axiosClient from "./axiosClient.js";

export function danhsachPhancong() {
    return axiosClient.get("phanconggiaovien/all");
}

export function layDanhsachPhancongGv(magiaovien) {
    return axiosClient.get(
        "phanconggiaovien/laydanhsachMonPhancong/" + magiaovien
    );
}

export function luuPhancong(danhsach, giaovien, bangxoaPhancong) {
    return axiosClient.post("phanconggiaovien/luu", {
        data: JSON.stringify(danhsach),
        giaovien: giaovien,
        xoaPhancong: JSON.stringify(bangxoaPhancong),
    });
}

export function xoaToanboPhancongcuaGiaovien(id) {
    return axiosClient.get("phanconggiaovien/xoaToanBoPhanmonGiaovien/" + id);
}
export function xuatBangphancong() {
    return axiosClient.get("phanconggiaovien/xuatBangphancong");
}
export function xoaToanboPhancongcuaMonhoc(monhoc, giaovien) {
    return axiosClient.post("phanconggiaovien/xoaPhancongchuyenmonTaimon", {
        giaovien: giaovien,
        mon: JSON.stringify(monhoc),
    });
}
