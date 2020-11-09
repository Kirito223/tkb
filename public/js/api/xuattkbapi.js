import axiosClient from "./axiosClient.js";

const xuattkbapi = {
    getListRoom: async function () {
        let result = await axiosClient.get("xuattkb/listRoom");
        return result;
    },
    getListLocation: async function () {
        let result = await axiosClient.get("xuattkb/listLocation");
        return result;
    },

    getListTeacher: async function () {
        let result = await axiosClient.get("xuattkb/listTeacher");
        return result;
    },
    getListClass: async function () {
        let result = await axiosClient.get("xuattkb/listClass");
        return result;
    },
    export: async function (params) {
        let result = await axiosClient.post("xuattkb/export", {
            param: params,
        });
        return result;
    },
    sendEmail: async function (params) {
        let result = await axiosClient.post("xuattkb/sendEmail", params);
        return result;
    },
};

export default xuattkbapi;
