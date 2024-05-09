import React from 'react'
import { useState,useEffect } from 'react';
const OrderTypeB = () => {
    const [menu, setMenu] = useState(null);
    const [items, setItems] = useState([]);
    const [user, setUser] = useState(null);

    useEffect(() => {
        axios.get('http://localhost/api/user')
        .then(res => {
             setUser(res.data);
        })
        .catch((err) => {
             console.error('fetching user data error', err);
        });
     }, []);

     const url = 'http://localhost/item.json';

    useEffect(() => {
        axios.get(url)
        .then(res => {
             setMenu(res.data.menu);
        })
        .catch((err) => {
             console.error('fetching error', err);
        });
     }, []);
      //typeB_change
      const handleCheckboxChange = (name, event) => {
        const isChecked = event.target.checked;
        console.log(isChecked,name,"check")
        if (isChecked) {
            setItems([...items, name]);
        } else {
            setItems(items.filter(item => item !== name));
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
          <div>
    {menu && (
        <form onSubmit={handleTypeBSubmit}>
        {Object.keys(menu).map(category => (
        <div key={category} className="">
            <h2>{category}</h2>
            {menu[category].map((item, index) => (
                <div key={index}>
                   <input 
                    onChange={(e) => handleCheckboxChange(`${category}-${item.name}`,e)}
                    type="checkbox" 
                    name={`${category}-${item.name}`} 
                    id={`${category}-${item.name}`} 
                    checked={items.includes(`${category}-${item.name}`)}
                />

                    <label htmlFor={`${category}-${item.name}`  }  id={`${category}-${item.name}`  }>
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
    </div>
  )
}

export default OrderTypeB