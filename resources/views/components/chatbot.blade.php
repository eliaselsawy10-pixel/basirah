<!-- Chatbot UI -->
<div id="basirah-chatbot-container" class="chatbot-container">
    <button id="chatbot-toggle-btn" class="chatbot-toggle-btn">
        <i class="fa-solid fa-comment-dots"></i>
    </button>

    <div id="chatbot-window" class="chatbot-window hidden">
        <div class="chatbot-header">
            <div>
                <i class="fa-solid fa-robot"></i>
                <span>Basirah Bot</span>
            </div>
            <button id="chatbot-close-btn" class="chatbot-close-btn">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        
        <div id="chatbot-messages" class="chatbot-messages">
            <div class="message bot-message">
                Hello! Welcome to Basirah. How can I help you today?
            </div>
        </div>

        <div class="chatbot-input-area">
            <input type="text" id="chatbot-input" placeholder="Type your message..." autocomplete="off">
            <button id="chatbot-send-btn">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<style>
    /* Chatbot Premium Design */
    :root {
        --chatbot-primary: #4F46E5; /* Indigo */
        --chatbot-primary-hover: #4338CA;
        --chatbot-bg: #ffffff;
        --chatbot-text: #1f2937;
        --chatbot-user-msg: #4F46E5;
        --chatbot-bot-msg: #f3f4f6;
        --chatbot-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }

    .chatbot-container {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        font-family: 'Inter', sans-serif;
    }

    .chatbot-toggle-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: var(--chatbot-primary);
        color: white;
        border: none;
        box-shadow: var(--chatbot-shadow);
        cursor: pointer;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), background-color 0.2s;
    }

    .chatbot-toggle-btn:hover {
        transform: scale(1.1);
        background-color: var(--chatbot-primary-hover);
    }

    .chatbot-window {
        position: absolute;
        bottom: 80px;
        right: 0;
        width: 350px;
        height: 500px;
        max-height: calc(100vh - 120px);
        background-color: var(--chatbot-bg);
        border-radius: 20px;
        box-shadow: var(--chatbot-shadow);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: opacity 0.3s ease, transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-origin: bottom right;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .chatbot-window.hidden {
        opacity: 0;
        transform: scale(0.5);
        pointer-events: none;
    }

    .chatbot-header {
        background: linear-gradient(135deg, var(--chatbot-primary), #818CF8);
        color: white;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .chatbot-header i {
        margin-right: 8px;
    }

    .chatbot-close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    .chatbot-close-btn:hover {
        opacity: 1;
    }

    .chatbot-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background-color: #f9fafb;
    }

    .message {
        max-width: 80%;
        padding: 12px 16px;
        border-radius: 18px;
        font-size: 0.95rem;
        line-height: 1.4;
        word-wrap: break-word;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bot-message {
        background-color: var(--chatbot-bot-msg);
        color: var(--chatbot-text);
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        border-bottom-left-radius: 4px;
        align-self: flex-start;
    }

    .user-message {
        background-color: var(--chatbot-user-msg);
        color: white;
        border-bottom-right-radius: 4px;
        align-self: flex-end;
    }
    
    .bot-message a {
        color: var(--chatbot-primary);
        font-weight: 600;
    }

    .chatbot-input-area {
        padding: 16px;
        background-color: var(--chatbot-bg);
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 10px;
    }

    #chatbot-input {
        flex: 1;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 20px;
        outline: none;
        font-size: 0.95rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    #chatbot-input:focus {
        border-color: var(--chatbot-primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    #chatbot-send-btn {
        background-color: var(--chatbot-primary);
        color: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    #chatbot-send-btn:hover {
        background-color: var(--chatbot-primary-hover);
    }

    @media (max-width: 480px) {
        .chatbot-window {
            width: calc(100vw - 40px);
            right: -10px;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toggleBtn = document.getElementById('chatbot-toggle-btn');
        const closeBtn = document.getElementById('chatbot-close-btn');
        const chatbotWindow = document.getElementById('chatbot-window');
        const messagesContainer = document.getElementById('chatbot-messages');
        const inputField = document.getElementById('chatbot-input');
        const sendBtn = document.getElementById('chatbot-send-btn');

        // Toggle Chatbot
        toggleBtn.addEventListener('click', () => {
            chatbotWindow.classList.toggle('hidden');
            if(!chatbotWindow.classList.contains('hidden')) {
                inputField.focus();
            }
        });

        closeBtn.addEventListener('click', () => {
            chatbotWindow.classList.add('hidden');
        });

        // Send Message
        const sendMessage = () => {
            const userText = inputField.value.trim();
            if (!userText) return;

            // Add user message
            appendMessage(userText, 'user');
            inputField.value = '';

            // Simulate typing delay
            setTimeout(() => {
                const botResponse = getBotResponse(userText);
                appendMessage(botResponse, 'bot');
            }, 600);
        };

        sendBtn.addEventListener('click', sendMessage);
        inputField.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });

        const appendMessage = (text, sender) => {
            const msgDiv = document.createElement('div');
            msgDiv.classList.add('message');
            msgDiv.classList.add(sender === 'user' ? 'user-message' : 'bot-message');
            
            // Allow HTML inside bot messages for links
            if (sender === 'bot') {
                msgDiv.innerHTML = text;
            } else {
                msgDiv.textContent = text;
            }

            messagesContainer.appendChild(msgDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        };

        // --- REGULAR EXPRESSION LOGIC ---
        const responses = [
            {
                pattern: /\b(?:hi|hello|hey|howdy|greetings)\b/i,
                response: "Hello there! How can I help you regarding our optical services?"
            },
            {
                pattern: /\b(?:book|appointment|consultation|doctor|meeting|see doctor)\b/i,
                response: "Looking to check your eyes? You can book a consultation with our experts here: <a href='/consultations'>Book an Appointment</a>"
            },
            {
                pattern: /\b(?:buy|shop|glasses|sunglasses|frames)\b/i,
                response: "We have a wide variety of eyewear available! Check them out here: <a href='/products'>Shop Products</a>"
            },
            {
                pattern: /\b(?:contacts|lenses|color|colored|contact lens)\b/i,
                response: "Looking for contact lenses? Browse our premium selection here: <a href='/products/color-lenses'>Color & Contact Lenses</a>"
            },
            {
                pattern: /\b(?:upload|ocr|prescription|script|measurements)\b/i,
                response: "You can easily upload your prescription or enter it manually here: <a href='/prescription/create'>Add Prescription</a>"
            },
            {
                pattern: /\b(?:cart|basket|checkout|pay)\b/i,
                response: "Ready to complete your purchase? <a href='/cart'>View Cart</a> or <a href='/checkout'>Checkout</a>"
            },
            {
                pattern: /\b(?:hours|location|about|who)\b/i,
                response: "You can find more information about Basirah on our <a href='/about'>About Us page</a>."
            },
            {
                pattern: /\b(?:thanks|thank you|bye|goodbye)\b/i,
                response: "You're very welcome! Let me know if you need anything else."
            }
        ];

        const getBotResponse = (input) => {
            for (let i = 0; i < responses.length; i++) {
                if (responses[i].pattern.test(input)) {
                    return responses[i].response;
                }
            }
            // Fallback
            return "I'm not quite sure I understand. Try asking about booking an appointment, our products, contact lenses, or uploading a prescription!";
        };
    });
</script>
