import axiosClient from "./axiosClient.js";

const sotiettoidangayApi = {
    getDuLieu: async function () {
        let result = await axiosClient.get("sotietngay/getdata");
        return result;
    },
    saveDulieu: async function(data){
        let result = await axiosClient.post("sotietngay/savedata", {data: data});
        return result;
    }
};

export default sotiettoidangayApi;
