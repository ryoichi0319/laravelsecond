import axios from "axios";
import { useEffect, useState } from "react";

const Order = () => {
    const [user, setUser] = useState(null);
    const [menu, setMenu] = useState(null);
    const [orders, setOrders] = useState([]);

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
            updatedOrders[orderIndex] = { category, selectedItem, quantity: 0, amount };
        
            setOrders(updatedOrders);
        } else {
            setOrders([...orders, { category, selectedItem, quantity: 0, amount }]);
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
//     useEffect(()=>{
// console.log(user?.id,"user.id")
// console.log(orders,"orders")

//     },[])
    const handleSubmit = (e) => {
       e.preventDefault();
       // サーバーに注文データを送信
       axios.post("/item", { orders })
       .then(res => {
        console.log("Data sent successfully:", res.data);
       })
       .catch(error => {
        console.log(error);
       });
    };

    console.log(orders,"orders")
    return (
        <div>
            
            {menu && (
                <form onSubmit={handleSubmit}>
                    {Object.keys(menu).map(category => (
                        <div key={category}>
                            <span className=" p-3 ">{category}</span>
                            <select className="m-5" value={orders.find(order => order.category === category)?.selectedItem || ""} 
                                    onChange={(e) => handleSelectChange(category, e)}>
                                <option value="">選択してください</option>
                                {menu[category].map((item, index) => (
                                    <option key={index} value={item.name}>
                                        {item.name}
                                        ￥{item.amount}
                                    </option>
                                ))}
                                
                            </select>
                            {orders.map(order => order.category === category) && (
                                <span>
                                    {orders.map((order) => order.price)}
                                </span>
                            )}
                            {orders.find(order => order.category === category) && (
                                <span>
                                    <select value={orders.find(order => order.category === category)?.quantity || 0} 
                                                    onChange={(e) => handleQuantityChange(category, e)}>
                                                     {[0, 1, 2, 3, 4, 5].map(value => (
                                            <option key={value} value={value}>
                                                {value}
                                            </option>
                                        ))}
                                    </select>
                                    
                                </span>
                            )}
                        </div>
                    ))}
                    <button type="submit">送信</button>
                </form>
            )}
        </div>
    );
};

export default Order;
