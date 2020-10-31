document.getElementById('importfile').addEventListener('change', handleFileSelect, false);
var ExcelToJSON = function() {

    this.parseExcel = function(file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });
            workbook.SheetNames.forEach(function(sheetName) {

                var xlsx = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);

                var arrResult = [];
                xlsx.forEach(function(element) {
                    let obj = {};
                    // Lap qua tung phan tu va tao obj moi chua cac key value nhu minh muon
                    for (const property in element) {
                        var str = property;
                        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
                        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
                        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
                        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
                        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
                        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
                        str = str.replace(/đ/g, "d", );
                        str = str.replace(/[!@#$%^&*-;()]/g, "");
                        str = str.replace(/\s+/g, '');
                        str = str.trim();

                        let key = str;
                        obj[key] = element[property];
                        // tao object moi chua key  da duoc thay doi cung value mac dinh
                    }
                    arrResult.push(obj);
                });
                if (arrResult != "") {
                    importexcel(arrResult);
                }

                // console.log(JSON.parse(XL_row_object));
            })
        };
        reader.onerror = function(ex) {
            console.log(ex);
        };
        reader.readAsBinaryString(file);
    };
};


function handleFileSelect(evt) {
    let idhuyen = $('#idhuyen').val();
    let idcaphoc = $('#idcaphoc').val();
    let idkhoihoc = $('#idkhoihoc').val();
    if(idhuyen == null ) {
        alert('Vui lòng chọn huyện');
    }
    if(idcaphoc == null ) {
        alert('Vui lòng chọn cấp học');
    }
    if(idkhoihoc == null ) {
        alert('Vui lòng chọn khối học');
    }
    if(idhuyen != null && idcaphoc != null && idkhoihoc != null) {
        Swal.fire({
            title: 'Lưu',
            text: "Bạn có muốn import file excel này không",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lưu'
        }).then((result) => {
            if (result.value) {
                var files = evt.target.files;
                var xl2json = new ExcelToJSON();
                xl2json.parseExcel(files[0]);

                $('#modalloading').modal('show');

                var i = 0;
                if (i == 0) {
                    i = 1;
                    var elem = document.getElementById("loading");
                    var width = 1;
                    var id = setInterval(frame, 80);

                    function frame() {
                        if (width >= 200) {
                            clearInterval(id);
                            i = 0;

                        } else {
                            width++;
                            elem.style.width = width + "%";
                            if (width == 200) {
                                $('#modalloading').modal('toggle');
                            }
                        }
                    }

                }

            }
            $('#importfile').val('');
        })
    }
    
}

function importexcel(datas) {
    let mahuyen = $('#idhuyen').val();
    let khoi = $('#idkhoihoc').val();
    var data = datas.map(function(value, key) {
        return {
            tenmon: value.Tenmon,
            sotiet: value.Sotiet,
            mahuyen: mahuyen,
            khoi: khoi
        }
    });
    axios.post('postexcelsotietmonhoctemp', data).then(function(response) {
        var data = response.data;

        if (data == 1) {
        	Swal.fire(
                'Import!',
                'Import thành công.',
                'success'
            )
            location.reload();
        }
    });
}

function reload () {

    let mahuyenvirial = $('#idhuyentt').val();
    let macaphocvirial = $('#idcaphoctt').val();
    $('#idhuyentt').select2({width: '100%'}).val(mahuyenvirial).trigger("change");
    $('#idcaphoctt').select2({width: '100%'}).val(macaphocvirial).trigger("change");

}

function danhsachsotietmonhoctemp(dataLoc,dataKhoiloc){
    var dataKhoiloc = dataKhoiloc;
    var datas = dataLoc.map(function (value, label) {
        let data = value;
        let stt = label + 1;
        var datas = Object.assign(data, {stt: stt.toString()});
        return datas;
    });
    // axios.get('getlisthuyen').then(function(response){
        // var dataHuyen = response.data;
        $("#griddssotietmonhoctemp").dxDataGrid({
            dataSource: datas,
            repaintChangesOnly: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: false
            },
            sorting: {
                mode: "multiple"
            },
            filterRow: {
               visible: true,
                 applyFilter: "auto"
             },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Tìm kiếm..."
            },
            editing: {
                mode: "batch",
                allowUpdating: true,
                selectTextOnEditStart: true,
                startEditAction: "click",
                allowAdding: true,
            },
            
            columns: [
            // {
            //     caption: "STT",               
            //     dataField: "stt",
            //     allowEditing: false,
            // },
            // {
            //     caption: "Huyện",               
            //     dataField: "mahuyen",
            //     lookup: {
            //         dataSource: dataHuyen,
            //         displayExpr: "tenhuyen",
            //         valueExpr: "mahuyen"
            //     }
            // },
            {
                caption: "Tên môn",                
                dataField: "tenmon",
            },
            {
                caption: "Khối",             
                dataField: "khoi",
                lookup: {
                    dataSource: dataKhoiloc,
                    displayExpr: "tenkhoi",
                    valueExpr: "makhoi"
                }
            },
            {
                caption: "Số tiết",                
                dataField: "sotiet",
            }
            ],
            //thêm
            onRowInserting: function(e) {
                var newData = e.data;
                var mahuyen = $('#idhuyentt').val();
                var tenmon = newData.tenmon;
                var khoi = newData.khoi;
                var sotiet = newData.sotiet;
                if(newData != "undefined"){
                    axios.post('addsotietmonhoc_temp', {
                        mahuyen: mahuyen,
                        tenmon: tenmon,
                        khoi: khoi,
                        sotiet: sotiet,
                    }).then(function(response) {
                        var data = response.data;
                        if(data == 1){
                            Swal.fire({
                            title: 'Lưu',
                                text: 'Đã lưu thành công',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            reload();
                        }
                        
                    });                 
                }
            },
            //sửa
            onRowUpdating: function(e) {
                var oldData = e.oldData;
                var newData = e.newData;
                var mtenmon = "tenmon";
                var mkhoi = "khoi";
                var msotiet = "sotiet";
                var id = oldData.idstmhtemp;
                var mahuyen = $('#idhuyentt').val();
                var tenmon;
                var khoi;
                var sotiet;

                if (mtenmon in newData) {
                    tenmon = newData.tenmon;
                }else{
                    tenmon = oldData.tenmon;
                }

                if (mkhoi in newData) {
                    khoi = newData.khoi;
                }else{
                    khoi = oldData.khoi;
                }

                if (msotiet in newData) {
                    sotiet = newData.sotiet;
                }else{
                    sotiet = oldData.sotiet;
                }
                
                axios.post('updatesotietmonhoc_temp', {
                    id: id,
                    mahuyen: mahuyen,
                    tenmon: tenmon,
                    khoi: khoi,
                    sotiet: sotiet,
                }).then(function(response) {
                    var data = response.data;
                    if(data == 1){
                        Swal.fire({
                        title: 'Cập nhật',
                            text: 'Cập nhật thành công',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        reload();
                    }
                });
            },


            onContextMenuPreparing: function(data) { 
                if (data.target == "content") {
                    if (!data.items) data.items = [];
                    data.items.push({
                        template: function () {
                            return $("<i class='fa fa-remove'>").text(" Xóa");                  
                        },
                        onItemClick: function() {
                            var id = data.row.data.idstmhtemp;
                            Swal.fire({
                                title: 'Xoá',
                                text: "Bạn có muốn xóa số tiết môn học này không!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes'
                            }).then((result) => {
                                if (result.value) {
                                    axios.post('delsotietmonhoc_temp', {
                                        id: id,
                                    }).then(function(response) {
                                        var data = response.data;
                                        if(data == 1){
                                            Swal.fire({
                                            title: 'Xoá',
                                                text: 'Xoá thành công',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            });
                                            reload();
                                        }
                                        
                                    });
                                }       
                            });
                        }
                    });
                    data.items.push({
                        template: function () {
                            return $("<i class='fa fa-remove'>").text(" Xóa toàn bộ");                  
                        },
                        onItemClick: function() {
                            var dulieu = datas;
                            var id= [];
                            dulieu.filter(function(items){
                                id.push({id:items.idstmhtemp})
                            });
                            Swal.fire({
                                title: 'Xoá',
                                text: "Bạn có muốn xóa toàn bộ số tiết môn học không",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes'
                            }).then((result) => {
                                if (result.value) {
                                    axios.post('delsotietmonhoc_tempall', {
                                        id: id,
                                    }).then(function(response) {
                                        var data = response.data;
                                        if(data == 1){
                                            Swal.fire({
                                            title: 'Xoá',
                                                text: 'Xoá thành công',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            });
                                            reload();
                                        }
                                        
                                    });
                                }       
                            });
                        }
                    });
                } 
            }
        });
    // });
}


window.onload = function() {
    $("#importexcel").prop("checked", false);
    $("#importdata").prop("checked", false);
    axios.get('getlisthuyen').then(function(response) {
        var datas = response.data;
        var selectListhuyen = document.getElementById('idhuyen');
        $('#idhuyen').append("<option value='none' selected='' disabled=''>--Chọn huyện--</option>");
        for(var i= 0; i< datas.length;i++){
          var option = document.createElement("option");
            option.value = datas[i].mahuyen;
            option.text = datas[i].tenhuyen;
            selectListhuyen.appendChild(option);
        }

        var selectListhuyentt = document.getElementById('idhuyentt');
        $('#idhuyentt').append("<option value='none' selected='' disabled=''>--Chọn huyện--</option>");
        for(var i= 0; i< datas.length;i++){
          var option = document.createElement("option");
            option.value = datas[i].mahuyen;
            option.text = datas[i].tenhuyen;
            selectListhuyentt.appendChild(option);
        }
    });
    $('#idhuyen').select2({
        width: '100%'
    });

    $('#idcaphoc').select2({
        width: '100%'
    });
    $('#idcaphoc').on('change',function(){
        var dataKhois = [
            {
                "macap" : 1,
                "datakhoi": [
                    {   
                        "makhoi" : 1,
                        "tenkhoi": "Khối 1"
                    },
                    {
                        "makhoi" : 2,
                        "tenkhoi": "Khối 2"
                    },
                    {
                        "makhoi" : 3,
                        "tenkhoi": "Khối 3"
                    },
                    {
                        "makhoi" : 4,
                        "tenkhoi": "Khối 4"
                    },
                    {
                        "makhoi" : 5,
                        "tenkhoi": "Khối 5"
                    }
                ]
            },
            {
                "macap" : 2,
                "datakhoi": [
                    {
                        "makhoi" : 6,
                        "tenkhoi": "Khối 6"
                    },
                    {
                        "makhoi" : 7,
                        "tenkhoi": "Khối 7"
                    },
                    {
                        "makhoi" : 8,
                        "tenkhoi": "Khối 8"
                    },
                    {
                        "makhoi" : 9,
                        "tenkhoi": "Khối 9"
                    },
                ]
            }
        ];
        $('#idkhoihoc').empty();
        let idcaphoc = $(this).val();
        let selectListkhoi = document.getElementById("idkhoihoc");
        $('#idkhoihoc').append("<option value='none' selected='' disabled=''>--Chọn khối--</option>");
        for (let i = 0; i < dataKhois.length; i++) {
            if(idcaphoc == dataKhois[i].macap){
                let dataKhoichild = dataKhois[i].datakhoi;
                for(let j = 0; j<dataKhoichild.length; j++){
                    var option = document.createElement("option");
                    option.value = dataKhoichild[j].makhoi;
                    option.text = dataKhoichild[j].tenkhoi;
                    selectListkhoi.appendChild(option);
                }
                
            }                
        }
        document.getElementById('divKhoihoc').style.display = "block";
    });
    $('#idkhoihoc').select2({
        width: '100%'
    });

    //nhập dữ liệu trực tiếp
    $('#idhuyentt').select2({
        width: '100%'
    });
    $('#idhuyentt').on('change',function(){
       $('#idcaphoctt').select2({width: '100%'}).val('none').trigger("change");
    });
    $('#idcaphoctt').select2({
        width: '100%'
    });

    $('#idcaphoctt').on('change',function(){
        var dataKhoistt = [
            {
                "macap" : 1,
                "datakhoi": [
                    {   
                        "makhoi" : 1,
                        "tenkhoi": "Khối 1"
                    },
                    {
                        "makhoi" : 2,
                        "tenkhoi": "Khối 2"
                    },
                    {
                        "makhoi" : 3,
                        "tenkhoi": "Khối 3"
                    },
                    {
                        "makhoi" : 4,
                        "tenkhoi": "Khối 4"
                    },
                    {
                        "makhoi" : 5,
                        "tenkhoi": "Khối 5"
                    }
                ]
            },
            {
                "macap" : 2,
                "datakhoi": [
                    {
                        "makhoi" : 6,
                        "tenkhoi": "Khối 6"
                    },
                    {
                        "makhoi" : 7,
                        "tenkhoi": "Khối 7"
                    },
                    {
                        "makhoi" : 8,
                        "tenkhoi": "Khối 8"
                    },
                    {
                        "makhoi" : 9,
                        "tenkhoi": "Khối 9"
                    },
                ]
            }
        ];
        let mahuyen = $('#idhuyentt').val();
        if(mahuyen == null){
            alert('Vui lòng chọn huyện');
        };
        let macaphoc = $('#idcaphoctt').val();
        axios.get('getDssotietmonhoctemp').then(function (response) {
            var data = response.data;
            let dataLoc = [];
            let dataKhoiloc;
            for(let i =0 ; i< data.length ; i++){
                if(mahuyen == data[i].mahuyen && macaphoc == data[i].macaphoc){
                    dataLoc.push(data[i]);
                }
            }
            for(let j =0; j<dataKhoistt.length;j++){
                if(macaphoc == dataKhoistt[j].macap){
                    dataKhoiloc = dataKhoistt[j].datakhoi;
                }
            }
            danhsachsotietmonhoctemp(dataLoc,dataKhoiloc);
        });
    });

}