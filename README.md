# Bidify - Real-Time Auction Platform

A modern, real-time auction platform built with Laravel 12, featuring live bidding, WebSocket communication, and responsive design.

## 🎯 Features

- **Real-Time Bidding**: Live bid updates using Laravel Echo & Pusher WebSockets
- **AJAX-Powered**: Smooth user experience without page reloads
- **Role-Based Access**: Admin and Publisher role management
- **Responsive Design**: Mobile-friendly Bootstrap 5 interface
- **Dynamic Categories**: Organized auction categories
- **Search Functionality**: Advanced product search capabilities
- **Countdown Timers**: Live auction end-time tracking
- **Bid History**: Complete bidding timeline with user info

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Laravel 12
- Node.js & NPM
- Pusher Account (for real-time features)

### Installation

1. **Clone & Install**
   ```bash
   git clone <repository-url>
   cd bidify
   composer install
   npm install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure Pusher** (for real-time bidding)
   ```env
   VITE_PUSHER_APP_KEY=your_pusher_key
   VITE_PUSHER_APP_CLUSTER=mt1
   BROADCAST_CONNECTION=pusher
   ```

4. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build Assets**
   ```bash
   npm run build
   ```

6. **Start Server**
   ```bash
   php artisan serve
   ```

## 🏗️ Architecture

### Backend
- **Laravel 12**: Modern PHP framework with elegant syntax
- **Eloquent ORM**: Powerful database relationships
- **Event Broadcasting**: Real-time WebSocket communication
- **Role Middleware**: Secure access control
- **AJAX Controllers**: RESTful API endpoints

### Frontend
- **Bootstrap 5**: Responsive, modern UI components
- **Axios**: HTTP client for AJAX requests
- **Laravel Echo**: Real-time event listening
- **Alpine.js**: Lightweight JavaScript framework
- **Vite**: Fast asset bundling

### Real-Time Features
- **WebSocket Connection**: Pusher-powered live updates
- **Event Broadcasting**: Laravel's event system
- **Channel Management**: Per-auction dedicated channels
- **Live UI Updates**: Instant bid notifications

## 📱 User Experience

### For Bidders
- **Live Auctions**: See bids in real-time
- **Instant Notifications**: Get notified of new bids
- **Smooth Interface**: No page reloads required
- **Mobile Responsive**: Bid from any device

### For Publishers
- **Easy Management**: Create and manage auctions
- **Live Tracking**: Monitor bidding activity
- **Role Protection**: Only manage own products
- **Analytics**: View bidding statistics

### For Administrators
- **Complete Control**: Full system administration
- **User Management**: Role-based access control
- **Category Management**: Organized product categories
- **System Monitoring**: Comprehensive oversight

## 🔧 Technical Implementation

### Real-Time Bidding Flow

1. **User Places Bid** → AJAX request to `/bids/place`
2. **Server Validation** → Check auction status, bid amount, permissions
3. **Database Update** → Save bid and update current price
4. **Event Broadcast** → `BidPlaced` event via Pusher
5. **Client Update** → All connected users receive live updates

### Key Components

#### Models & Relationships
```php
Product -> hasMany(Bid)
Bid -> belongsTo(Product, User)
User -> hasMany(Bid)
Category -> hasMany(Product)
```

#### Real-Time Events
```php
BidPlaced // Broadcasts new bid to auction channel
```

#### AJAX Endpoints
```php
POST /bids/place          // Submit new bid
GET  /bids/{id}/history  // Fetch bid history
```

## 🎨 Design Features

- **Modern UI**: Clean, professional interface
- **Responsive Layout**: Works on all screen sizes
- **Visual Feedback**: Loading states and animations
- **Error Handling**: User-friendly error messages
- **Accessibility**: Semantic HTML and ARIA labels

## 🔒 Security Features

- **CSRF Protection**: All forms protected
- **Role Validation**: Secure access control
- **Input Sanitization**: Prevent XSS attacks
- **SQL Injection Prevention**: Parameterized queries
- **Authentication**: Secure user sessions

## 📊 Performance

- **Optimized Queries**: Eager loading relationships
- **Asset Caching**: Vite production builds
- **Database Indexing**: Fast query performance
- **Lazy Loading**: Efficient resource usage

## 🚀 Deployment

### Production Setup

1. **Environment Configuration**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Asset Optimization**
   ```bash
   npm run build
   ```

3. **Cache Optimization**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## 🛠️ Development

### Available Commands

```bash
php artisan serve          # Start development server
php artisan migrate         # Run database migrations
php artisan db:seed         # Populate with sample data
npm run dev              # Start Vite development server
npm run build           # Build for production
```

### Testing

```bash
php artisan test          # Run PHPUnit tests
npm run test            # Run frontend tests
```

## 📝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Few screenshots:
Welcome page:
<img width="3024" height="3818" alt="Image" src="https://github.com/user-attachments/assets/bca534da-c3a5-4142-965c-92534ada3601" />
Categories page:
<img width="3024" height="4835" alt="Image" src="https://github.com/user-attachments/assets/2e32d5a3-b01e-4aa4-8cb5-6a07307fef4a" />
Category detail page:
<img width="3024" height="2832" alt="Image" src="https://github.com/user-attachments/assets/c7198ab9-0477-493f-adba-d1b5061cd6c0" />
How it works page:
<img width="3024" height="6051" alt="Image" src="https://github.com/user-attachments/assets/474aec14-7bca-484d-a7f6-80419d60364b" />