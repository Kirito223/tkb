import axiosClient from "./axiosClient.js";

const xuattkbapi = {
    getListTeacher: async function () {
        let result = await axiosClient.get("xuattkb/listTeacher");
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
