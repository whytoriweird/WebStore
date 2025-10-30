// Simple product data
const products = {
    Websites: [
        {
            name: "Landing Page",
            description: "Простий сайт-візитка",
            price: "5000 грн",
            image: "/img/landing.jpg"
        },
        {
            name: "E-commerce",
            description: "Інтернет-магазин",
            price: "15000 грн",
            image: "/img/shop.jpg"
        },
        {
            name: "Corporate",
            description: "Корпоративний сайт",
            price: "10000 грн",
            image: "/img/corporate.jpg"
        }
    ]
};

// Basic variables
let cart = [];
const container = document.getElementById('productContainer');

// Load products
function loadProducts() {
    container.innerHTML = '';
    products.Websites.forEach(product => {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <img src="${product.image}" alt="${product.name}" class="product-image">
            <h2>${product.name}</h2>
            <p>${product.description}</p>
            <p class="price">${product.price}</p>
            <button onclick="addToCart('${product.name}', '${product.price}')">Замовити</button>
        `;
        container.appendChild(card);
    });
}

// Cart functions
function addToCart(name, price) {
    cart.push({ name, price });
    updateCart();
    alert('Додано до кошика!');
}

function updateCart() {
    const cartItems = document.getElementById('cartItems');
    cartItems.innerHTML = '';
    let total = 0;

    cart.forEach((item, index) => {
        const itemEl = document.createElement('div');
        itemEl.className = 'cart-item';
        itemEl.innerHTML = `
            <span>${item.name}</span>
            <span>${item.price}</span>
            <button onclick="removeFromCart(${index})">✖</button>
        `;
        cartItems.appendChild(itemEl);
        total += parseInt(item.price);
    });

    document.getElementById('cartTotal').textContent = `Всього: ${total} грн`;
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCart();
}

function checkout() {
    if (cart.length === 0) {
        alert('Кошик порожній!');
        return;
    }
    alert('Дякуємо за замовлення!');
    cart = [];
    updateCart();
}

// Initialize
document.addEventListener('DOMContentLoaded', loadProducts);