//生成数独解决方案
const Toolkit = require("./toolkit");

module.exports = class Generator1{


    internalGenerate(board){
        this.b = board;
        this.t = 0;
    }
    //检查每行每列及每宫是否有相同项
    /*check(x,y,value){
        //检查行
        for(var row_item in this.b[x]){
            if (row_item == value){
                return false;
            }

        }
        //检查列
        for(var row_all in this.b){
            if (row_all[y] == value){
                return false;
            }
        }
        //检查宫
        const row=x/3*3;
        const col=y/3*3;
        const row3col3=this.b[row][col:col+3]+this.b[row+1][col:col+3]+this.b[row+2][col:col+3];
        for(var row3col3_item in row3col3){
            if (row3col3_item == value){
                return false;
            }
        }
        return true;
    }*/
    //得到下一个未填项
    get_next(x,y){
        for (let n =y+1;n<=9;n++){
            if (this.b[x][n] == value){
                return {x,n};
            }
        }
        for (let r =x+1;r<=9;r++){
            for (let c =0;c<=9;c++){
                if (this.b[r][c] == 0){
                    return {r,c};
                }
            }
        }
        return [-1,-1];  //若无下一个未填项，返回-1
    }
    //主循环
    try_it(x,y){
        //
        if (this.b[x][y] == 0){
            for (let i =0;i<=9;i++){
                //从1到9尝试
                this.t += 1;
                if(Toolkit.matrix.checkFillable(this.b,i,x,y)){
                    //符合 行列宫均无条件 的
                    this.b[x][y]=i;//将符合条件的填入0格
                    const {next_x,next_y}=this.get_next(x,y);//得到下一个0格
                    if(next_x==-1){
                        return true;//如果无下一个0格,返回True
                    }else{
                        //如果有下一个0格，递归判断下一个0格直到填满数独
                        const end=this.try_it(next_x,next_y);
                        if(!end){
                            //在递归过程中存在不符合条件的，即 使try_it函数返回None的项
                            this.b[x][y] = 0
                        }else{
                            return true;
                        }

                    }
                };
            }
        }
    }

    //主调用
    start(){
        if(this.b[0][0]==0){
            this.try_it(0,0);
        }else{
            const {x,y}= this.get_next(0,0);
            this.try_it(x,y);
        }
        for(var a in this.b){
            return a;
        }
    }
};

/*const generator = new Generator();
generator.generate();
console.log(generator.matrix)*/



















