var i = 0;
var kho;
var lop;
var thoikhoaBieutam;
var vong = 0;
var khoitao = 0;
var dsphancong;

var Rangbuoc = [];
var Lophoc = [];
var Phonghoc = [];
let giaovien=[];
/**
 * Hàm sắp xếp thời khóa biểu
 * hàm này sẽ xắp sếp thời khóa biểu từ bảng dữ liệu tạm ban đầu
 */
function xeptkb() {
   
    vong++;
    //Sap xep thoi khoa bieu
    for (let index = 0; index < thoikhoaBieutam.length; index++) {
        // Tim va kiem tra rang buoc
        let kiemtraRangbuoc = true;
        if (kiemtraRangbuoc) {
            doicho(
                thoikhoaBieutam,
                getRndInteger(0, thoikhoaBieutam.length - 1),
                getRndInteger(0, thoikhoaBieutam.length - 1)
            );
        }
    }
    // sau khi xử lý dữ liệu thì gọi hàm post để gửi trả về cho main theard
    postMessage({ tkb: thoikhoaBieutam, vong: vong });
    // Đợi một khoảng thời gian sau đó gọi lại hàm và xếp tiếp
    setTimeout(xeptkb,1500);
}
function getRndInteger(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
function doicho(mang, vitri, vitridoi) {
    let trunggian = mang[vitridoi];
    mang[vitridoi] = mang[vitri];
    mang[vitri] = trunggian;
}

function PushOut(index)
{
    let item=thoikhoaBieutam[index];
    //cap nhat thong tin giao vien
    let timgv = giaovien.findIndex((x) => x.magiaovien == item.magiaovien);
    let tiet=item.tiet*item.buoi+item.tiet;
        if(timgv>=0)
        {
            if(item.thu==2)
            {
                giaovien[timgv].lich.T2[tiet-1]=0;
            }
            if(item.thu==3)
            {
                giaovien[timgv].lich.T3[tiet-1]=0;
            }
            if(item.thu==4)
            {
                giaovien[timgv].lich.T4[tiet-1]=0;
            }
            if(item.thu==5)
            {
                giaovien[timgv].lich.T5[tiet-1]=0;
            }
            if(item.thu==6)
            {
                giaovien[timgv].lich.T6[tiet-1]=0;
            }
            if(item.thu==7)
            {
                giaovien[timgv].lich.T7[tiet-1]=0;
            }
        }
    capnhatthongtin(giaovien[timgv]);
    item.magiaovien=0;
    item.mamon=0;
    item.hovatengv="";
    item.tenmon="";
    
}
function trunglich(giaovien,thu,tiet,buoi)
{
    
         tiet=tiet*buoi+tiet;
            if(timgv>=0)
            {
                if(thu==2)
                {
                    if(  giaovien.lich.T2[tiet-1]==0) return true;
                    return false;
                }
                if(thu==3)
                {
                    if(  ggiaovien.lich.T3[tiet-1]==0) return true;
                    return false;
                }
                if(thu==4)
                {
                    if(  giaovien.lich.T4[tiet-1]==0) return true;
                    return false;
                }
                if(thu==5)
                {
                    if(  giaovien.lich.T5[tiet-1]==0) return true;
                    return false;
                }
                if(thu==6)
                {
                    if(  giaovien.lich.T6[tiet-1]==0) return true;
                    return false;
                }
                if(thu==7)
                {
                    if(  giaovien.lich.T7[tiet-1]==0) return true;
                    return false;
                }
            }
}
function thoadieukien(item,tiethoc)
{
    if(tiethoc.malop==item.malop)
    {
        let timgv = giaovien.findIndex((x) => x.magiaovien == tiethoc.magiaovien);
        let tiet=item.tiet*item.buoi+item.tiet;
            if(timgv>=0)
            {
                if(item.thu==2)
                {
                    if(  giaovien[timgv].lich.T2[tiet-1]==0) return true;
                    return false;
                }
                if(item.thu==3)
                {
                    if(  giaovien[timgv].lich.T3[tiet-1]==0) return true;
                    return false;
                }
                if(item.thu==4)
                {
                    if(  giaovien[timgv].lich.T4[tiet-1]==0) return true;
                    return false;
                }
                if(item.thu==5)
                {
                    if(  giaovien[timgv].lich.T5[tiet-1]==0) return true;
                    return false;
                }
                if(item.thu==6)
                {
                    if(  giaovien[timgv].lich.T6[tiet-1]==0) return true;
                    return false;
                }
                if(item.thu==7)
                {
                    if(  giaovien[timgv].lich.T7[tiet-1]==0) return true;
                    return false;
                }
            }
        //kiểm tra giáo viên không trùng lịch dạy

        return true;
    }  
    
    return false;
}
function CX(tiethoc,thu)
{
    
    
    let danhsachGv = kho.giaovien;
    
    let danhsachMonhoc = kho.monhoc;
    thoikhoaBieutam.some((item) => {
        //kiểm tra các điều kiện ràng buộc, điều kiện vi phạm trước khi xếp
        if(item.thu==thu&&item.tinhtrang==1&&item.magiaovien==0&&tiethoc.trangthai==0)
        if(thoadieukien(item,tiethoc))
        {
            let timgv = danhsachGv.findIndex((x) => x.id == tiethoc.magiaovien);
            let monhoc = danhsachMonhoc.findIndex((x) => x.id == tiethoc.mamonhoc);
            let GV = danhsachGv[timgv];
                item.magiaovien= tiethoc.magiaovien
                item.mamon= tiethoc.mamonhoc;
                item.hovatengv=GV.hovaten;
                item.tenmon= danhsachMonhoc[monhoc].tenmonhoc;
            tiethoc.trangthai=1;
            //cạp nhật lịch dạy giáo viên
            timgv = giaovien.findIndex((x) => x.magiaovien == tiethoc.magiaovien);
            if(timgv>=0)
            {
                giaovien[timgv].old=giaovien[timgv].new;

                // số tiết trống trong 1 tuần thay đổi
                giaovien[timgv].new.TE=giaovien[timgv].new.TE-1;
                //cập nhật lịch
                if(item.thu==2)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T2[tiet-1]=1;
                }
                if(item.thu==3)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T3[tiet-1]=1;
                }
                if(item.thu==4)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T4[tiet-1]=1;
                }
                if(item.thu==5)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T5[tiet-1]=1;
                }
                if(item.thu==6)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T6[tiet-1]=1;
                }
                if(item.thu==7)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T7[tiet-1]=1;
                }
                capnhatthongtin(giaovien[timgv]);
            }
            
            return true;
               
        }
    });
    return false;
}
function xeptietcodinh(tiethoc,thu,tiet,buoi)
{
    
    
    let danhsachGv = kho.giaovien;
    
    let danhsachMonhoc = kho.monhoc;
    thoikhoaBieutam.some((item) => {
        //kiểm tra các điều kiện ràng buộc, điều kiện vi phạm trước khi xếp
        if(item.thu==thu&&item.tinhtrang==1&&item.magiaovien==0&&item.tiet==tiet&&item.buoi==buoi)
        if(thoadieukien(item,tiethoc))
        {
            let timgv = danhsachGv.findIndex((x) => x.id == tiethoc.magiaovien);
            let monhoc = danhsachMonhoc.findIndex((x) => x.id == tiethoc.mamonhoc);
            let GV = danhsachGv[timgv];
                item.magiaovien= tiethoc.magiaovien
                item.mamon= tiethoc.mamonhoc;
                item.hovatengv= GV.hovaten;
                item.tenmon= danhsachMonhoc[monhoc].tenmonhoc;
            tiethoc.trangthai=1;
            //cạp nhật lịch dạy giáo viên
            timgv = giaovien.findIndex((x) => x.magiaovien == tiethoc.magiaovien);
            if(timgv>=0)
            {
                giaovien[timgv].old=giaovien[timgv].new;

                // số tiết trống trong 1 tuần thay đổi
                giaovien[timgv].new.TE=giaovien[timgv].new.TE-1;
                //cập nhật lịch
                if(item.thu==2)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T2[tiet-1]=1;
                }
                if(item.thu==3)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T3[tiet-1]=1;
                }
                if(item.thu==4)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T4[tiet-1]=1;
                }
                if(item.thu==5)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T5[tiet-1]=1;
                }
                if(item.thu==6)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T6[tiet-1]=1;
                }
                if(item.thu==7)
                {
                    let tiet=item.tiet*item.buoi+item.tiet;
                    giaovien[timgv].lich.T7[tiet-1]=1;
                }
                capnhatthongtin(giaovien[timgv]);
            }
            
            return true;
               
        }
    });
    return false;
}
function MoveTo(index1,index2)
{
    //bổ sung thêm thuật toán gội đệ quy để có thể duy chuyển trong trường hợp index2 có người được phân công rồi
    let item1=thoikhoaBieutam[index1];
    let item2=thoikhoaBieutam[index2];
    if(trunglich(item2,item1.thu,item1.tiet,item1.buoi))
    {
        return MoveTo(index2,index2+1);
        
    }
    else
    {
        return item2;
    }
    
}

function capnhatthongtin(giaovien)
{

    let lich=giaovien.lich;
    let buoinghi=0;
    if(lich.T2[0]+lich.T2[1]+lich.T2[2]+lich.T2[3]+lich.T2[4]>0)buoinghi++;
    if(lich.T2[5]+lich.T2[6]+lich.T2[7]+lich.T2[8]+lich.T2[9]>0)buoinghi++;
    if(lich.T3[0]+lich.T3[1]+lich.T3[2]+lich.T3[3]+lich.T3[4]>0)buoinghi++;
    if(lich.T3[5]+lich.T3[6]+lich.T3[7]+lich.T3[8]+lich.T3[9]>0)buoinghi++;
    if(lich.T4[0]+lich.T4[1]+lich.T4[2]+lich.T4[3]+lich.T4[4]>0)buoinghi++;
    if(lich.T4[5]+lich.T4[6]+lich.T4[7]+lich.T4[8]+lich.T4[9]>0)buoinghi++;
    if(lich.T5[0]+lich.T5[1]+lich.T5[2]+lich.T5[3]+lich.T5[4]>0)buoinghi++;
    if(lich.T5[5]+lich.T5[6]+lich.T5[7]+lich.T5[8]+lich.T5[9]>0)buoinghi++;
    if(lich.T6[0]+lich.T6[1]+lich.T6[2]+lich.T6[3]+lich.T6[4]>0)buoinghi++;
    if(lich.T6[5]+lich.T6[6]+lich.T6[7]+lich.T6[8]+lich.T6[9]>0)buoinghi++;
    if(lich.T7[0]+lich.T7[1]+lich.T7[2]+lich.T7[3]+lich.T7[4]>0)buoinghi++;
    if(lich.T7[5]+lich.T7[6]+lich.T7[7]+lich.T7[8]+lich.T7[9]>0)buoinghi++;
    giaovien.old=giaovien.new;
    giaovien.new.FHD=14-buoinghi;
    giaovien.new.ME=(60-giaovien.new.TE)/14;
    giaovien.new.MP=(60-giaovien.new.TE)/14;
    giaovien.new.FFD=(14-buoinghi)/2;
    giaovien.new.QMA=giaovien.new.FHD+giaovien.new.ME+giaovien.new.MP+giaovien.new.FFD;
    giaovien.new.GM=giaovien.new.QMA+giaovien.new.CMA;
}
function Taothoikhoabieutam() {

    if(khoitao==0)
    {
        // Gui tin nhan toi worker cho phep hoat dong
        // khởi tạo mảng thời khóa biểu tạm
        let danhsachLop = kho.lophoc;
        danhsachLop.forEach((lop) => {
            for (let thu = 2; thu < 8; thu++) {
                for (let tiet = 1; tiet < 11; tiet++) {
                    // chỗ này sử dụng phương thức gán vào mảng đã có chứ ko push

                    thoikhoaBieutam.push({
                        thu: thu,
                        magiaovien: 0,
                        hovatengv: "",
                        malop: lop.id,
                        tenlop: lop.tenlop,
                        mamon: 0,
                        tenmon: 0,
                        buoi:tiet <= 5 ? 0 : 1,
                        tiet: tiet <= 5 ? tiet : tiet-5,
                        tinhtrang:0,//nghi học
                    });
                }
            }
        });
        thoikhoaBieutam.forEach((item) =>{
            let danhsachtiethoc = kho.sotiettrongbuoi;
            danhsachtiethoc.forEach((th) => {
            if(th.malop==item.malop && th.buoi==item.buoi && th.sotiet>=item.tiet)
            {
                
                    item.tinhtrang=1;//co hoc
            }
        });
        });
        //khoi tao giao vien
        let danhsachgiaovien = kho.giaovien;
        
        danhsachgiaovien.forEach((gv) => {
            
                    // chỗ này sử dụng phương thức gán vào mảng đã có chứ ko push
                    let lich={
                        T2:[0,0,0,0,0,0,0,0,0,0],
                        T3:[0,0,0,0,0,0,0,0,0,0],
                        T4:[0,0,0,0,0,0,0,0,0,0],
                        T5:[0,0,0,0,0,0,0,0,0,0],
                        T6:[0,0,0,0,0,0,0,0,0,0],
                        T7:[0,0,0,0,0,0,0,0,0,0],

                    };
                    let data={
                        
                        ME:5,// Số tiết trống trong một buổi học
                        TE:60,//Tổng số tiết tróng trong một tuần
                        FHD:14, //Số lượng buổi nghỉ trong tuần
                        FFD:7, //Số lượng ngày nghỉ trong tuần
                        MP: 5, //số lượng tiết dạy tối đa trong buổi
                        LB:0, //Có dạy qua trưa hay không
                        QMA:0,//tổng kết đánh giá 6 thông tin trên
                        NH:0,//Số lượng các tiết bị phá vở ràng buộc Nghỉ, Bận, Hnaj chế
                        D1:0,//Số buổi vi phạm ràng buộc nghỉ theo tiết
                        D2:0, // Số buổi vi phạm ràng buộc nghỉ buổi học
                        D3:0,//Số buổi vi phạm ràng buộc dạy Max trong buổi học
                        FHDB:0,//Có vi phạm ràng buộc số buổi nghỉ dạy hay không
                        CMA:0,//Tổng kết đánh giá 6 tiêu chí thỏa mãn ràng buộc
                        GM:0,//Tổng kết toán bộ 12 tiêu chí đánh giá
                        
                    };
                    let datanew={
                        
                        ME:5,// Số tiết trống trong một buổi học
                        TE:60,//Tổng số tiết tróng trong một tuần
                        FHD:14, //Số lượng buổi nghỉ trong tuần
                        FFD:7, //Số lượng ngày nghỉ trong tuần
                        MP: 5, //số lượng tiết dạy tối đa trong buổi
                        LB:0, //Có dạy qua trưa hay không
                        QMA:0,//tổng kết đánh giá 6 thông tin trên
                        NH:0,//Số lượng các tiết bị phá vở ràng buộc Nghỉ, Bận, Hnaj chế
                        D1:0,//Số buổi vi phạm ràng buộc nghỉ theo tiết
                        D2:0, // Số buổi vi phạm ràng buộc nghỉ buổi học
                        D3:0,//Số buổi vi phạm ràng buộc dạy Max trong buổi học
                        FHDB:0,//Có vi phạm ràng buộc số buổi nghỉ dạy hay không
                        CMA:0,//Tổng kết đánh giá 6 tiêu chí thỏa mãn ràng buộc
                        GM:0,//Tổng kết toán bộ 12 tiêu chí đánh giá
                        
                    };

                    giaovien.push( 
                    { magiaovien:gv.id,
                        old:data,
                        new:datanew,
                        lich:lich,
                    }
                    );
          
        });
        //tao bang phan cong chuyen mon
        let danhsachphancong = kho.phancongchuyenmon;
        let danhsachchuaphan=[];
        danhsachphancong.forEach((pc) => {
            let trongso=pc.sotiet*10;
            for (let sotiet = 1; sotiet <= pc.sotiet; sotiet++) 
            {
                let giatri=0;
                if(sotiet<=2) giatri=trongso/sotiet;
                if(sotiet>2 && sotiet<=4) giatri=trongso/sotiet*2;
                if(sotiet>4 ) giatri=trongso/sotiet*3;
                danhsachchuaphan.push({
                    magiaovien:pc.magiaovien,
                    malop:pc.malop,
                    mamonhoc:pc.mamonhoc,
                    trangthai:0,
                    giatri:giatri,

                }

                );
            }
            let danhsachMonhoc = kho.monhoc;
            let monhoc = danhsachMonhoc.findIndex((x) => x.id == pc.mamonhoc);
            if(monhoc>=0)
            if(danhsachMonhoc[monhoc].tenmonhoc=='Chào cờ')
            {
                timgv = giaovien.findIndex((x) => x.magiaovien == pc.magiaovien);
                if(timgv>=0)
                {
                    giaovien[timgv].new.CMA=50;
                }
            }
            
            
            
        });
        //loại bỏ các môn đã được phân cố định
        let dstietcodinh=kho.tietcodinh;

        dstietcodinh.forEach((pc) => {
            
            let tiethoc={
                magiaovien:pc.magiaovien,
                malop:pc.malop,
                mamonhoc:pc.monhoc,
                trangthai:0,

            };
            xeptietcodinh(tiethoc,pc.thu,pc.tiet,pc.buoi);
            let index = danhsachchuaphan.findIndex((x) => x.magiaovien == pc.magiaovien&&x.malop==pc.malop&&x.mamonhoc==pc.monhoc);
            if(index>=0)
            {
                danhsachchuaphan[index].trangthai=1;
            }
            
        });

        dsphancong=danhsachchuaphan;
        khoitao=1;
    }
    // Lay danh sach cac giao vien
   
    // Lap tao thoi khoa bieu
    //let danhsachphancong=kho.danhsachchuaphan;
    //1. Sắp xếp giáo viên theo độ ưu tiên
    dsphancong.sort(function(a, b)
    {
        let gva = giaovien.findIndex((x) => x.magiaovien == a.magiaovien);
        let gvb = giaovien.findIndex((x) => x.magiaovien == b.magiaovien);
		 if(gva<=-1||gvb<=-1) return false;
        return giaovien[gva].new.GM+a.giatri>giaovien[gvb].new.GM+b.giatri;
    
    });
    //2. Xếp lịch học thứ 2
    dsphancong.forEach((gv) => {
        if(gv.trangthai==0)CX(gv,2);
		
    });
    dsphancong.sort(function(a, b)
    {
        let gva = giaovien.findIndex((x) => x.magiaovien == a.magiaovien);
        let gvb = giaovien.findIndex((x) => x.magiaovien == b.magiaovien);
		 if(gva<=-1||gvb<=-1) return false;
        return giaovien[gva].new.GM>giaovien[gvb].new.GM;
    
    });
    //3. Xếp lịch học thứ 7
    dsphancong.forEach((gv) => {
        if(gv.trangthai==0)CX(gv,7);
		
    });
    dsphancong.sort(function(a, b)
    {
        let gva = giaovien.findIndex((x) => x.magiaovien == a.magiaovien);
        let gvb = giaovien.findIndex((x) => x.magiaovien == b.magiaovien);
		 if(gva<=-1||gvb<=-1) return false;
        return giaovien[gva].new.GM>giaovien[gvb].new.GM;
    
    });
    //4. Xếp lịch học thứ 3
    dsphancong.forEach((gv) => {
        if(gv.trangthai==0)CX(gv,3);
		
    });
    dsphancong.sort(function(a, b)
    {
        let gva = giaovien.findIndex((x) => x.magiaovien == a.magiaovien);
        let gvb = giaovien.findIndex((x) => x.magiaovien == b.magiaovien);
		 if(gva<=-1||gvb<=-1) return false;
        return giaovien[gva].new.GM>giaovien[gvb].new.GM;
    
    });
    //5. Xếp lịch học thứ 4
    dsphancong.forEach((gv) => {
        if(gv.trangthai==0)CX(gv,4);
		
    });
    dsphancong.sort(function(a, b)
    {
        let gva = giaovien.findIndex((x) => x.magiaovien == a.magiaovien);
        let gvb = giaovien.findIndex((x) => x.magiaovien == b.magiaovien);
		 if(gva<=-1||gvb<=-1) return false;
        return giaovien[gva].new.GM>giaovien[gvb].new.GM;
    
    });
    //6. Xếp lịch học thứ 5
    dsphancong.forEach((gv) => {
        if(gv.trangthai==0)CX(gv,5);
		
    });
    dsphancong.sort(function(a, b)
    {
        let gva = giaovien.findIndex((x) => x.magiaovien == a.magiaovien);
        let gvb = giaovien.findIndex((x) => x.magiaovien == b.magiaovien);
		 if(gva<=-1||gvb<=-1) return false;
        return giaovien[gva].new.GM>giaovien[gvb].new.GM;
    
    });
    //7. Xếp lịch học thứ 6
    dsphancong.forEach((gv) => {
        if(gv.trangthai==0)CX(gv,6);
		
    });
    //7. Xếp lịch học thứ 7
    dsphancong.forEach((gv) => {
        if(gv.trangthai==0)CX(gv,7);
		
    });
    //8. Điền các tiết còn trống
    //8.1 Duyệt ds các tiết chưa phân công
    // dsphancong.forEach((gv) => {
    //     if(gv.trangthai==0)
    //     {
    //         //kiểm tra xem có tiết nào trống chưa xếp mà xếp được hoăc tiết nào trống có thể đổi được thì xếp vào
    //         //if(item.thu==thu&&item.tinhtrang==1&&item.magiaovien==0)
    //         //let index=thoikhoaBieutam.findIndex((x) => x.magiaovien == a.magiaovien);
    //         //MoveTo(index,index);
    //     }
		
    // });
    //9. Xử lý trường hợp trùng phòng
    //9.1 Duyệt ds đã phân công nếu có 2 tiết dạy cùng phòng thì hoán đổi một tiết đi
    //10. Tối ưu thời khóa biểu
    //10.1. Tinh chỉnh thời khóa biểu theo biểu đồ đánh giá


    
    xeptkb();
}
self.addEventListener("message", function (e) {
    kho = e.data.kho;
    thoikhoaBieutam = e.data.thoikhoaBieutam;
   
    Taothoikhoabieutam();
});
