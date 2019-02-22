/**
 *矩阵和数组相关工具
 * @type {{makeRow, makeMatrix, shuffle}}
 */
const marrixToolkit = {
    makeRow(v=0) {
        const array = new Array(9);
        array.fill(v);
        return array;
    },

    makeMatrix(v=0) {
        return Array.from({length:9},()=>this.makeRow(v))
    },

    /**
     * 对传入数组进行随机排序,然后把这个数组返回来
     * Fisher-Yates 洗牌算法
     */
    shuffle(array) {
        const endIndex = array.length-2;
        for (let i=0;i<=endIndex;i++){
            const j = i + Math.floor(Math.random()*(array.length - i));
            [array[i],array[j]] = [array[j],array[i]];
        }
        return array;
    },

    /**
     *TODD 检查指定位置是否可以填数字n
     */
    checkFillable(matrix,n,rowIndex,colIndex){
        const row = matrix[rowIndex];
        const column = this.makeRow().map((v,i)=>matrix[i][colIndex]);
        const { boxIndex } = boxToolkit.convertToBoxIndex(rowIndex,colIndex);
        const box = boxToolkit.getBoxCells(matrix,boxIndex);
        for (let i = 0;i<9;i++){
            if(row[i] === n
                || column[i] ===n
                || box[i]===n)
                return false;
        }
        return true;
    }
};

/**
 *宫坐标系工具
 * @type {{getBoxCells, convertToBoxIndex, convertFromBoxIndex}}
 */
const boxToolkit={
    //TODD
    getBoxCells(matrix,boxIndex){
        const starRowIndex = Math.floor(boxIndex / 3) * 3;//得到方格行坐标
        const starColIndex = boxIndex % 3 * 3;//得到方格列坐标
        const result = []//准备一个数组存放取出来的9个值
        for (let cellIndex = 0;cellIndex < 9;cellIndex++) {
            const rowIndex = starRowIndex + Math.floor(cellIndex/3);//起始位置+偏移量
            const colIndex = starColIndex + cellIndex % 3;//起始位置+偏移量
            result.push(matrix[rowIndex][colIndex]);
        }
        return result;
    },

    convertToBoxIndex(rowIndex,colIndex){
        return {
            boxIndex:Math.floor(rowIndex / 3) * 3 +Math.floor(colIndex / 3),
            cellIndex:rowIndex % 3 *3 + colIndex %3
        };
    },

    convertFromBoxIndex(boxIndex,cellInderx){
        return {
            rowIndex:Math.floor(boxIndex / 3) * 3 + Math.floor(cellInderx / 3),
            colIndex:boxIndex % 3 * 3 + cellInderx % 3
        }
    }
}
//工具集

module.exports = class Tollkit{
    /**
     * 矩阵和数组相关工具
     * @returns {{makeRow, makeMatrix, shuffle}}
     */
    static get matrix(){
        return marrixToolkit;
    }

    /**
     * 宫坐标系相关工具
     * @returns {{makeRow, makeMatrix, shuffle}}
     */
    static get box(){
        return boxToolkit;
    }
};















