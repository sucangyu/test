//生成数独解决方案
const Toolkit = require("./toolkit");

module.exports = class Generator1{


    internalGenerate(board){
        this.b = board;
        this.t = 0;
    }


    //得到下一个未填项
    get_next(x,y){
        for (let n=y+1;n<9;n++){
            if (this.b[x][n] == 0){
                return [x,n];
            }
        }
        for (let r =x+1;r<9;r++){
            for (let c =0;c<9;c++){
                if (this.b[r][c] == 0){
                    return [r,c];
                }
            }
        }
        return [-1,-1];  //若无下一个未填项，返回-1
    }
    //主循环
    try_it(x,y){
        //
        if(this.b[x][y] == 0){

            for (let i =1;i<=9;i++){
                //从1到9尝试
                this.t += 1;
                if(Toolkit.matrix.checkFillable(this.b,i,x,y)){
                    //检查指定位置是否可以填数字n,可以进来,不可以循环尝试下个数字
                    this.b[x][y]=i;//将符合条件的填入[x][y]格替换0

                    const [next_x,next_y]=this.get_next(x,y);//得到下一个0格
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
                }
            }
        }
    }

    //主调用
    start(){

        if(this.b[0][0]==0){
            this.try_it(0,0);
        }else{
            const [x,y]= this.get_next(0,0);
            this.try_it(x,y);
        }
        return this.b;
        /*for(var a in this.b){
            return a;
        }*/
    }
};

/*const generator = new Generator();
generator.generate();
console.log(generator.matrix)*/



















