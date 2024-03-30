import axios from "axios";
import { useEffect, useState } from "react";  
import { Container, Typography, FormControl, InputLabel, Select, MenuItem, Button, Grid } from "@mui/material";
import { light } from "@mui/material/styles/createPalette";

const Order = () => {
    const [user, setUser] = useState(null);
    const [menu, setMenu] = useState(null);
    const [orders, setOrders] = useState([]);
    const [test, setTest] = useState(null)
    const [items, setItems] = useState([]);
    const [message,setMessage] = useState('')



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
       axios.get(url)
       .then(res => {
            setMenu(res.data.menu);
       })
       .catch((err) => {
            console.error('fetching error', err);
       });
    }, []);

    //テスト
    // useEffect(() => {
    //     axios.get("http://localhost/item1.json")
    //     .then(res => {
    //          setTest(res.data.menu);
    //     })
    //     .catch((err) => {
    //          console.error('fetching error', err);
    //     });
    //  }, []);
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
        console.log(amount, 'amount');
        console.log(orderIndex,"orderIndex")
        if (orderIndex !== -1) {
            const updatedOrders = [...orders];
            updatedOrders[orderIndex] = { category, selectedItem, quantity: 1, amount };
        
            setOrders(updatedOrders);
        } else {
            setOrders([...orders, { category, selectedItem, quantity: 1, amount }]);
        }
        console.log(selectedItem,"selectedItem")

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
        return orders.reduce((total, order) => total + (order.amount * order.quantity), 0);
    };
console.log(menu)
//     },[])
    const handleSubmit = (e) => {
       e.preventDefault();
       // サーバーに注文データを送信
       axios.post("/item", { orders })
       .then(res => {
        if (res.data.message) {
           setMessage(res.data.message); // または他の適切な方法でメッセージを表示する
        }
        console.log("送信しました", res.data);
        
        setOrders([])

        
       })
       .catch(error => {
        console.log(error);
       });
    };
    //typeB_change
    const handleCheckboxChange = (event) => {
        const itemName = event.target.name;
        if (event.target.checked) {
            setItems([...items, itemName]);
        } else {
            setItems(items.filter(item => item !== itemName));
        }
    };
 
     //typeB_submit
     const handleTypeBSubmit = (e) => {
        e.preventDefault();
        // サーバーに注文データを送信
        axios.post("/item", { items })
        .then(res => {
         console.log("Data sent successfully:", res.data,"res.data");
        })
        .catch(error => {
         console.log(error);
        });
     };

    

    return (
        <div>
            
            {menu && (
                <Container maxWidth="md">
                <Typography  gutterBottom
                  sx={{ fontWeight: 'right', textAlign: 'center',textTransform: 'capitalize',m:1 }}>
                    order form
                    </Typography>
                <form onSubmit={handleSubmit}>
                    
                    {Object.keys(menu).map(category => (
                        <div key={category}>
                            <span className=" p-3 ">{category}</span>
                            <Grid item xs={12} key={category}>

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
                                    <MenuItem key={index} value={item.name}>
                                    {item.name}
                                   
                                    ￥{item.amount}
                                </MenuItem>
                                ))}
                                
                            </Select>
                            </FormControl>
                            </Grid>


                            {/* {orders.map(order => order.category === category) && (
                                <span>
                                    {orders.map((order) => order.price)}
                                </span>
                            )} */}
                          <Grid item xs={4} className=" flex justify-end">

                           <FormControl className=" w-36  ">
                            {orders.find(order => order.category === category) && (
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
                             </div>

                    ))}
                  <Button type="submit" variant="contained" color="primary" 
                  fullWidth disabled={!orders.length}>
                    Submit Order
                    </Button >
                    {message && !orders.length && <p className=" text-red-500">{message}</p>}
                   
                </form>
                </Container>
            )}
          <div>
    {menu && (
        <form onSubmit={handleTypeBSubmit}>
        {Object.keys(menu).map(category => (
        <div key={category} className="">
            <h2>{category}</h2>
            {menu[category].map((item, index) => (
                <div key={index}>
                    <input 
                        onChange={handleCheckboxChange}
                        type="checkbox" 
                        name={`${category}-${item.name}`} // カテゴリーとアイテムの名前を組み合わせて一意な名前を作成する
                        id={`${category}-${item.name}`} 
                    />
                    <label htmlFor={`${category}-${item.name}`}>
                        {item.name} ￥{item.amount}
                    </label>
                </div>
            ))}
        </div>
        
    ))}
                        <button type="submit">送信</button>

    </form>
     ) } 
</div>
            
            <div>
                合計金額: ￥{calculateTotalAmount()}
            </div>

            {/* <div>
               {test && test.map((m,index) => (
                <div key={index}>
                    {m.category}
                    {m.items[0].name}
                </div>
               ))}
               {test && test[0].category}
               
            </div> */}
        </div>
    );
};

export default Order;
