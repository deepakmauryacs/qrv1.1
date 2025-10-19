<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <title></title>
    <style type="text/css">
        // Variables
        $primary-color: #1779ba;
        $secondary-color: #0b386f;
        $gray:  #9b9b9b;
        $light-gray: #eeeeee;
        $medium-gray: #c8c3be;
        $dark-gray: #96918c;
        $black: #322d28;
        $white: #f3f3f3;
        $body-background: #ffffff;
        $body-font-color: $black;

        $sans: 'Montserrat', sans-serif;
        $serif: 'Lora', Georgia, serif;



        body {
          font-family: $sans;
          font-weight: 400;
          color: $body-font-color;
        }
        header.top-bar {
          h1 {
            font-family: $sans;
          }
        }
        main {
          margin-top: 4rem;
          min-height: calc(100vh - 107px);
          .inner-container {
            max-width: 800px;
            margin: 0 auto;
          }
        }

        table.invoice {
          background: #fff;
          .num {
            font-weight: 200;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: .8em;
          }
          tr, td {
            background: #fff;
            text-align: left;
            font-weight: 400;
            color: $body-font-color;
          }
          tr {
            &.header {
              td {
                img {
                  max-width: 300px;
                }
                h2 {
                  text-align: right;
                  font-family: $sans;
                  font-weight: 200;
                  font-size: 2rem;
                  color: $primary-color;
                }
              }
            }
            &.intro {
              td {
                &:nth-child(2) {
                  text-align: right;
                }
              }
            }
            &.details {
              > td { 
                padding-top: 4rem; 
                padding-bottom: 0; 
              }
              td, th {
                &.id,
                &.qty {
                  text-align: center;
                }
                &:last-child {
                  text-align: right;
                }
              }
              table {
                thead, tbody {
                  position: relative;
                  &:after {
                    content: '';
                    height: 1px;
                    position: absolute;
                    width: 100%;
                    left: 0;
                    margin-top: -1px;
                    background: $medium-gray;
                  }
                }
              }
            }
            &.totals {
              td {
                padding-top: 0;
              }
              table {
                tr {
                  td {
                    padding-top:0;
                    padding-bottom:0;
                    &:nth-child(1) {
                      font-weight: 500;
                    }
                    &:nth-child(2) {
                      text-align: right;
                      font-weight: 200;
                    }
                  }
                  &:nth-last-child(2) {
                    
                    td {
                      padding-bottom: .5em;
                      &:last-child {
                        position: relative;
                        &:after {
                          content: '';
                          height: 4px;
                          width: 110%;
                          border-top: 1px solid $primary-color;
                          border-bottom: 1px solid $primary-color;
                          position: relative;
                          right: 0;
                          bottom: -.575rem;
                          display: block;
                        }
                      }
                    }
                    
                  }
                  &.total {
                    td {
                      font-size: 1.2em;
                      padding-top: .5em;
                      font-weight: 700;
                      &:last-child {
                        font-weight: 700;
                      }
                    }
                  }
                }
              }
            }
          }
        }

        .additional-info {
          h5 {
            font-size: .8em;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: $primary-color;
          }
        }
    </style>
</head>
<body>

    <!-- <header class="top-bar align-center">
      <div class="top-bar-title">
        <h1>Invoice Template <small>with Foundation Flex-Grid Layout</small></h1>
      </div>
    </header> -->
    <div class="row expanded">
      <main class="columns">
        <div class="inner-container">
        <header class="row align-center">
            <a class="button hollow secondary" href="{{ route('vendor.invoice.index') }}"><i class="ion ion-chevron-left"></i> Back</a>
            <!-- &nbsp;&nbsp;<a class="button"><i class="ion ion-ios-printer-outline"></i> Print Invoice</a> -->
        </header>
        <section class="row">
          <div class="callout large invoice-container">
            <table class="invoice">
              <tr class="header">
                <td class="">
                  <img src="{{ asset('admin/img/digital-qr.jpg') }}" alt="Company Name" style="width: 80px;" />
                </td>
                <td class="align-right">
                  <h2>Invoice</h2>
                </td>
              </tr>
              <tr class="intro">
                <td class="">
                  Hello, Philip Brooks.<br>
                  Thank you for your order.
                </td>
                <td class="text-right">
                  <span class="num">Order #00302</span><br>
                  October 18, 2017
                </td>
              </tr>
              <tr class="details">
                <td colspan="2">
                  <table>
                    <thead>
                      <tr>
                        <th class="desc">Item Description</th>
                        <th class="id">Item ID</th>
                        <th class="qty">Quantity</th>
                        <th class="amt">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="item">
                        <td class="desc">Name or Description of item</td>
                        <td class="id num">MH792AM</td>
                        <td class="qty">1</td>
                        <td class="amt">$100.00</td>
                      </tr>
                    </tbody>
                  </table>
                </td> 
              </tr>
              <tr class="totals">
                <td></td>
                <td>
                  <table>
                    <tr class="subtotal">
                      <td class="num">Subtotal</td>
                      <td class="num">$100.00</td>
                    </tr>
                    <tr class="fees">
                      <td class="num">Shipping & Handling</td>
                      <td class="num">$0.00</td>
                    </tr>
                    <tr class="tax">
                      <td class="num">Tax (7%)</td>
                      <td class="num">$7.00</td>
                    </tr>
                    <tr class="total">
                      <td>Total</td>
                      <td>$107.00</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            
            <section class="additional-info">
            <div class="row">
              <div class="columns">
                <h5>Billing Information</h5>
                <p>Philip Brooks<br>
                  134 Madison Ave.<br>
                  New York NY 00102<br>
                  United States</p>
              </div>
              <div class="columns">
                <h5>Payment Information</h5>
                <p>Credit Card<br>
                  Card Type: Visa<br>
                  &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 1234
                  </p>
              </div>
            </div>
            </section>
          </div>
        </section>
        </div>
      </main>
    </div>
</body>
</html>