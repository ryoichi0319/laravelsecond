import axios from "axios";
import { useEffect, useState,useRef } from "react";  
import { Container, Typography, FormControl, InputLabel, Select, MenuItem, Button, Grid } from "@mui/material";
import SendIcon from '@mui/icons-material/Send';
import { spacing } from '@mui/system';
import { useCookies } from 'react-cookie';
import './style.css'
import { InertiaLink } from '@inertiajs/inertia-react';
import { styled } from '@mui/system';


const Order = ({order_id}) => {
    const [user, setUser] = useState(null);
    const [order,setOrder] = useState([])
    const [menu, setMenu] = useState(null);
    const [orders, setOrders] = useState([]);
    const [test, setTest] = useState(null)
    const [items, setItems] = useState([]);
    const [message,setMessage] = useState('')
    const [cookies, setCookie] = useCookies(['name']);
    const [todos, setTodos] = useState([])
    const [inputValue, setInputValue] = useState('');

    const StyledText = styled('div')({
        fontFamily: 'Georgia, serif',
        fontSize: '18px',
        fontWeight: 'bold',
        color: 'GrayText', 
      });

    const elementRef = useRef(null);
    useEffect(()=>{
        console.log(order_id)

    },[])
  useEffect(() => {
    const handleScroll = () => {
      if (elementRef.current) {
        const elementTop = elementRef.current.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;
        // console.log(elementTop,"eletop")  
        // console.log(windowHeight,"windowheight")
        
        // 要素が画面内に表示されたかどうかをチェック
        if (elementTop < windowHeight) {
          // 要素が画面内に表示されたらアニメーションを開始
          elementRef.current.classList.add('slide-up');
          // スクロールイベントを監視する必要がなくなったら削除
          window.removeEventListener('scroll', handleScroll);
        }
      }
    };

    // コンポーネントがマウントされた時点でスクロールイベントを監視
    window.addEventListener('scroll', handleScroll);

    // コンポーネントがアンマウントされた時点でスクロールイベントのリスナーを削除
    return () => {
      window.removeEventListener('scroll', handleScroll);
    };
  }, []);



    const handleSetCookie = () => {
        // 'name'という名前のCookieに'value'という値を設定
        setCookie('name', 'value', { path: '/' });
        alert('Cookieが設定されました！');
      };


    const url = 'http://localhost/item.json';

    useEffect(() => {
        axios.get('http://localhost/api/user')
        .then(res => {
             setUser(res.data);
        })
        .catch((err) => {
             console.error('fetching user data error', err);
        });
     }, []);

     useEffect(() => {
        axios.get('http://localhost/api/orders')
            .then(res => {
                setOrder(res.data); // データを取得した後、order を更新
            })
            .catch((err) => {
                console.error('fetching order data error', err);
            });
    }, []);
     
    useEffect(() => {
       axios.get(url)
       .then(res => {
            setMenu(res.data.menu);
       })
       .catch((err) => {
            console.error('fetching error', err);
       });
    }, []);

   
    useEffect(() => {
    console.log(menu,"menu")

    },[])


    
    //orderIndex !== -1は既存の注文が見つかった場合(カテゴリーを始めて選んだ場合)
    //もしも既存の注文があれば新しいorders配列のカテゴリーのインデックスにあうメニューに例(category: 'salad', selectedItem: 'フレッシュ', quantity: 0)追加
    const handleSelectChange = (category, event) => {
        const selectedItem = event.target.value;
        const orderIndex = orders.findIndex(order => order.category === category);
        const selectedItemData = menu[category].find(item => item.name === selectedItem);
        const amount = selectedItemData ? selectedItemData.amount : 0;
        if (orderIndex !== -1) {
            const updatedOrders = [...orders];
            updatedOrders[orderIndex] = { category, selectedItem, quantity: 1, amount };
        
            setOrders(updatedOrders);
        } else {
            setOrders([...orders, { category, selectedItem, quantity: 1, amount }]);
        }

    };
    
    const handleQuantityChange = (category, event) => {
        const quantity = parseInt(event.target.value);
        const orderIndex = orders.findIndex(order => order.category === category);
        if (orderIndex !== -1) {
            const updatedOrders = [...orders];
            updatedOrders[orderIndex] = { ...updatedOrders[orderIndex], quantity };
            setOrders(updatedOrders);
        }
    };

     // 注文合計金額を計算する関数
     const calculateTotalAmount = () => {
        const total = orders.reduce((total, order) => total + (order.amount * order.quantity), 0);
        return total.toLocaleString();
    };
//     },[])
    const handleSubmit = (e) => {
       e.preventDefault();
       // サーバーに注文データを送信
       axios.post("/item/store", { orders })
       .then(res => {
        if (res.data.message) {
           setMessage(res.data.message); // または他の適切な方法でメッセージを表示する
        }
        
        setOrders([])

        
       })
       .catch(error => {    
        console.log(error);
       });
    };
   
   
    return (
        <div className="italian-background text-center mx-auto max-w-2xl">
            <StyledText>

       

            
            
            {menu && (
                <Container maxWidth="md">
                <Typography  gutterBottom
                  sx={{fontSize: '30px',  fontWeight: 'right', textAlign: 'center',textTransform: 'capitalize',m:1 }}>
                    order form
                    </Typography>
                <form onSubmit={handleSubmit} className=" ">
                    
                    {Object.keys(menu).map(category => (
                        <div key={category}>
                            <span className=" p-3 text-red-400 font-bold text-xl">{category}</span>
                            <Grid item  key={category}>

                            <FormControl fullWidth>
                          <InputLabel>Select item</InputLabel>
                            <Select
                            value={orders.find(order => order.category === category)?.selectedItem || ""}
                            onChange={(e) => handleSelectChange(category, e)}
                            variant="outlined"
                            
                          >
                                <MenuItem value="">
                                   <em>Select item</em>
                                </MenuItem>
                                {menu[category].map((item, index) => (
                        <MenuItem key={item.id} value={item.name}>
                            <div className="flex items-center flex-1">
                                <div className="w-3/5 font-mono text-xl">{item.name}</div>
                                <div className="w-1/5">￥{item.amount.toLocaleString()}</div>
                                <div className="w-1/5">
                                    <img className="w-24 h-24 rounded-md shadow-md" src={item.img_url} alt="" />
                                </div>
                            </div>
                        </MenuItem>
))}

                                
                            </Select>
                            </FormControl>
                            </Grid>


                            {orders.map(order => order.category === category) && (
                                <span>
                                    {orders.map((order) => order.price)}
                                </span>
                            )}
                       {  
                          <Grid item xs={4} className=" flex justify-end">

                           <FormControl className=" w-36  ">
                            {orders.find(order => order.category === category && order.selectedItem) && (
                                    <Select value={orders.find(order => order.category === category)?.quantity || 0} 
                                                    onChange={(e) => handleQuantityChange(category, e)}>

                                                     {[ 1, 2, 3, 4, 5].map(value => (
                                            <MenuItem key={value} value={value} className=" w-96" >
                                                {value}
                                            </MenuItem>
                                        ))}
                                    </Select>  
   
                            )}
                            </FormControl>
                        </Grid>
}
                             </div>

                    ))}
                  <Button type="submit" variant="contained" color="success" startIcon={<SendIcon />}
                  fullWidth sx={{ mt: 4 }} disabled={!orders.length}>
                    Submit Order
                    </Button >

                    {message && !orders.length && <p className=" text-red-500">{message}</p>}
                        {order.map(order => (
                            <div key={order.id}>
                    
                    <InertiaLink href={`item/order/${order.id}`}>

                     <div className="my-5 flex flex-col items-center gap-2 p-4 bg-red-500 rounded-md shadow-md hover:shadow-lg transition duration-300">
        <div className="text-xl font-semibold text-white">オーダーID: {order.id}</div>
        <div className="text-lg text-white">テーブル番号: {order.table_number}</div>
                      </div>
                      </InertiaLink>


                            </div>



                        ))}
                    

                </form>
                </Container>
                
            )}


      <div className=" text-gray-800">
                合計金額: ￥{calculateTotalAmount()}
            </div>
            <div></div>
    

      <div ref={elementRef}>
    
      </div>

         
            </StyledText>
        </div>
    );
};

export default Order;
