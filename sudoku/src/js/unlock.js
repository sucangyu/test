const UnlockGrid = require("./ui/unlockGrid");
const Popupnumbers = require("./ui/popupnumbers");

const unlockGrid = new UnlockGrid($("#container"));
unlockGrid.unlockBuild();
unlockGrid.layout();

const popupnumbers = new Popupnumbers($("#popupNumbers"));
unlockGrid.bindPopup(popupnumbers);

//按钮组
$("#check").on("click",e=>{
    unlockGrid.unlock();
});

$("#rebuild").on("click",e=>{
    unlockGrid.unRebuild();
});














































