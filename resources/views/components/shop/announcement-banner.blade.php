<aside
    id="delivery-announcement"
    class="delivery-announcement"
    role="status"
    aria-label="Delivery announcement"
>
    <div class="delivery-announcement__content">
        <span class="delivery-announcement__icon" aria-hidden="true">🚚</span>
        <p class="delivery-announcement__message">
            Home Delivery is available in Lahore only. For deliveries to any other city in Pakistan, please contact us at
            <a href="tel:03004290159" aria-label="Call OceanLife at 0300-4290159">0300-4290159</a>
            before placing your order.
        </p>
    </div>
</aside>

@once
    <style>
        .delivery-announcement {
            position: relative;
            display: flex;
            min-height: 48px;
            width: 100%;
            align-items: center;
            overflow: hidden;
            background: #1E40AF;
            color: #FFFFFF;
            box-shadow: 0 1px 8px rgba(30, 64, 175, 0.28);
        }

        .delivery-announcement__content {
            display: flex;
            width: max-content;
            flex: 0 0 auto;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            animation: delivery-announcement-scroll 34s linear infinite;
            will-change: transform;
        }

        .delivery-announcement:hover .delivery-announcement__content {
            animation-play-state: paused;
        }

        .delivery-announcement__icon {
            flex: 0 0 auto;
            font-size: 1.1rem;
            line-height: 1;
        }

        .delivery-announcement__message {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.35;
            white-space: nowrap;
        }

        .delivery-announcement__message a {
            color: inherit;
            white-space: nowrap;
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 2px;
        }

        .delivery-announcement__message a:hover {
            text-decoration-thickness: 2px;
        }

        .delivery-announcement__message a:focus-visible {
            border-radius: 4px;
            outline: 2px solid #fff;
            outline-offset: 2px;
        }

        @keyframes delivery-announcement-scroll {
            from { transform: translateX(100vw); }
            to { transform: translateX(-100%); }
        }

        @media (max-width: 639px) {
            .delivery-announcement {
                min-height: 48px;
            }

            .delivery-announcement__content {
                gap: 6px;
                animation-duration: 30s;
            }

            .delivery-announcement__icon {
                font-size: 0.9rem;
            }

            .delivery-announcement__message {
                font-size: 0.875rem;
                line-height: 1.3;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .delivery-announcement__content {
                animation: none;
                margin-inline: auto;
                white-space: normal;
            }

            .delivery-announcement__message {
                white-space: normal;
                text-align: center;
            }
        }
    </style>
@endonce
