import React from 'react'
import Modal from "@/Components/Modal";

const Order_test = () => {
    const [showModal, setShowModal] = useState(false);

    モーダル

    const handleOpenModal = () => {
        setShowModal(true);
      };
    
      const handleCloseModal = () => {
        setShowModal(false);
      };

  return (
    <div>Order_test
     {/* <button onClick={handleOpenModal}>Open Modal</button>
                <Modal show={showModal} onClose={handleCloseModal}>
                    <div>
                    <h2>Modal Content</h2>
                    <p>This is the content of the modal.</p>
                    <button onClick={handleCloseModal}>Close Modal</button>
                    </div>
                </Modal> */}
                </div>
  )
}

export default Order_test