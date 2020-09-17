import axiosClient from "./axiosClient.js";

const sotiettoidaBuoiApi = {
    getDuLieu: async function () {
        let result = await axiosClient.get("sotietbuoi/getdata");
        return result;
    },
    saveDulieu: async function (data) {
        let result = await axiosClient.post("sotietbuoi/savedata", {
            data: data,
        });
        return result;
    },
};

export default sotiettoidaBuoiApi;
