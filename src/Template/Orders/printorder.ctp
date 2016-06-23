<?php
    echo $this->Html->script('jspdf.min');
    $this->Html->addCrumb('Orders', '/orders');
    $this->Html->addCrumb('Print Order', ['controller' => 'Orders', 'action' => 'printorder',$order->id]);
?>

<script>
    function generatePDF() {
        var doc = new jsPDF();
        var orderNum = <?php echo $order->id; ?>;
        var custName = '<?php echo $customer->firstname;?>' +' '+'<?php echo $customer->surname;?>';
        var custContact = '<?php echo $customer->phone; ?>';
        var custEmail = '<?php echo $customer->email; ?>';
        var custAddress = '<?php echo $customer->address; ?>';
        var custSuburb = '<?php echo $customer->suburb; ?>';
        var custPost = '<?php echo $customer->postcode; ?>';
        var description =  '<?php echo $order->description; ?>';
        var dateToday = '<?php echo $this->Format->formatDate($now);?>';
        var dateCreated = '<?php echo $this->Format->formatDate($order->created);?>';
        var orderStatus = '<?php echo $order->orderStatusName;?>';
        var paymentStatus = '<?php echo $order->paymentStatusName;?>';
        var vendor = '<?php echo $order->vendorName;?>';
        var quote = '<?php echo $this->Number->currency($order->quote);?>';
        var balanceRemaining = '<?php echo $this->Number->currency($order->balance);?>';

        var fileName = 'Order ' + orderNum + '.pdf';
        var engageLogo = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAf/AABEIAIABDQMBEQACEQEDEQH/xAGiAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgsQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+gEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoLEQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2dri4+Tl5ufo6ery8/T19vf4+fr/2gAMAwEAAhEDEQA/AP7+KACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoA/kC/wCD1b/lFl8A/wDs/wD+Fn/rOv7VVAH9ftABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAfyBf8AB6t/yiy+Af8A2f8A/Cz/ANZ1/aqoA/r9oAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgD+QL/g9W/wCUWXwD/wCz/wD4Wf8ArOv7VVAH9ftABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAfyBf8Hq3/ACiy+Af/AGf/APCz/wBZ1/aqoA/r9oAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgD+QL/g9W/5RZfAP/s//AOFn/rOv7VVAH9ftAHx/+058bPiH4O1jwH8IfgxpFjdfFb4qTXsOj+IPECAeF/C9nZW15dvcXTyRy29zrF/Fp2pf2TaXEctsq6fe3VzBdLFFaXHFi69SEqdGhFOtWbUZS+CCSbu+jk7PlXk277OopO7eyPLPiF8S/wBs3wyPAfw7s7f4I2Hjnx9Br8WmatPrmua/rNjYeD9I/tfxH4t16UeDvC3grSLSFFtraKVdHvrF7vWrG3NhC0E7nGpVx0PZ00sOqlTmtJylKSUI80py9yFOK2V7NXktBpR1etl+vzuQw/8ABQvwPpGh3ej+JPCXi0+PtEvdP8KX50jXPh9r3gy78RXkAjhvT8VtP1Sw+H9lZvKBcajd39rpMemu04bRVhs7qG3P7Spxi4zhP2kWoO0qcoOb2ftk1TS6ttRtr7ugcj8rb9b/AHbjPh78Xf2w9R8WX/w71LTfglq+q3Pg8/Erwzdan4rvYNW1TwXqev3mkJbWPijwX4W1TwJrmueF50tLDUrq28N6bpjPf6VfvDdw3MkbFOvjXN0msPJuHtYNzd3TcnGynCDpylDRNqCWqetwaja+u9vn89T0L9nv40fF+X4neLvgF8etHs7jxzoOmJ4t0jxj4aNpdaJdeHtSnY2Gja7PYado9jDriwCSfTbi10rTxqtjaX32jTbG606SS90w1et7WeGxEV7SK54zhrFxb0jJpJKVtU0lzJPRNappWuttrH21XeSfOfxN/aa8A/Dm9udEiW68U+I7RniutN0iSFLPT7hDhrbU9VlLRQXCMGSW3tIL+5tpUaK7ht3GK+xyTgrNs4pQxMuTA4OolKnWxCk6laD2nQoRtKcGrOM6kqUJxalTlNHy2b8XZblVSeHXPjMVBtTpUHFQpSW8K1aV4xkndSjCNScGmpxizwUftw33n7j8OLT7NvJ8oeKJvP8ALzwvnnQfLLgdX+zhSf4Bnj6r/iGNPlt/bM+e2/1GPLfvy/W728ue/mfNf8RDqc3/ACKocl9vrkua3+L6ta/ny/I+hvhh+0d4A+JdzDpEclx4c8STYWHRdaaFVv5DklNJ1CJzbXrgYxbyrZ30h3GGzkjjeQfIZ3wdm2SwliJRhjMHHWWJwyk/ZLviKMlz0k/54upSWilUUmon1GUcVZZm0o0E5YXFy0jh8Q4r2j7UaqfJUf8AdfJUevLTaTZ9AV8mfTHI+MvHnhP4f6X/AGv4t1q10i0dnS3WXfLd3syKGaCwsoFkuryUAqXWCJxErK8zRxnfXoZdlWPzav8AV8vw1TEVEk5uNo06UW7KVWrJxp04vWznJczVo3ehw4/MsFllH2+OxEKEHdQUrudSSV3GnTinOpLuoxdr3lZany9qP7a/gaC4aPTPCnifULdSyi5uX0zT/MxgB44RdXr7G5K+aYpNu0tGrEqv3FHw0zSUE6+PwNGbSfJBV61r9JS9nTV115eZXvaTWr+Pq+IOWxm1RweMqxX25expX81Hnm7P+9yvulsun8J/tefC/wAQXMNlq6ax4SuJmCLc6vbw3Gk73ICK1/p89xJACxw813Z21tEvzyzogZl4cf4fZ5hISq4d4fMIRTbhh5yjiLLVtUq0IKT7Rp1Kk5PSMG7J9eC45ybFTjTrqvgZSdlKvCMqN3or1aUpuPnKcIQjvKSWp9RW9xb3lvBd2k8N1a3UMVxbXNvKk9vcW86LLDPBNEzRzQzRsskUsbMkiMroxUg18POE6c5U6kZQqQlKE4Ti4zhOLcZRlGSTjKLTUotJpppq59jGUZxjOEozhOKlCcWpRlGSvGUZK6lGSaaabTTutBZ54LWCa5uZore2t4pJ7i4nkSKCCCJDJLNNLIVjiiijVnkkdlREUsxABNEYynKMIRlOc5KMIRTlKUpO0YxiruUpNpJJNtuy1HKUYRlOclGMU5SlJqMYxiruUm7JJJNtt2S1Z8deOP2yfCWh3s2n+D9CuvFzQO0UmqzXn9jaSzqSC1kWs729voww2+Y9vZRSf6yCWaLa7/omV+HOYYqlGtmOKhl6klKNCNP6ziEn0qpVKdOk2tbKdSS2nGMrpfCZjx5gcPUlSwOHnjnF2daVT2FBtbum3CpUqJPS7hTi94ykrN+e/wDDb+rf9E80/wD8KK5/+VNev/xDGh/0OKv/AIRw/wDmg8z/AIiFW/6FdL/wqn/8oD/ht/Vv+ieaf/4UVz/8qaP+IY0P+hxV/wDCOH/zQH/EQq3/AEK6X/hVP/5QfbPw88VSeOPBXhzxZLZJp0mu6et69lHM1wlsWllj8tZ2jhaQDy87jGh5xjivzTN8AsszLGYCNR1lhazpKq4qDnZJ3cVKSjvtzP1P0DK8Y8wy/C42VNUniaSqOmpc6hdtWUmo323sjmfiH8bPh58Mm+zeJNZL6sYxKmg6VF/aGsNGyhkeWBXjgsklUhoX1G5s0nHMLOAcduUcM5xnfv4LDWw6bi8VXl7HDpp2ajNpyquL0kqMKji/iSOPNOIcryj3cXiL17cyw1Fe1rtNXTcE1GmmvhdWdNS+y2fP8n7bfhATMsPgvxJJbhwFlkvNMimKcZZoFkmRX64QXDg8fvBnj6yPhnmPKnLMsEp21jGnXlFPspuMW158i9D5l+IWA5ny4DFuN9G50Yyt3cVKST8uZ+p6/wDD39o/4Z/EO8t9JstQu9C1y6ZIrXSPEUEVlLezudohsbuC4utPuZXkwsFv9rjvbjegitC29E+ezfg3O8npzxFWjTxWFgnKeIwcpVY04rXmq05Qp1oRS1lP2bpws71LWb9zK+K8ozWpGhTqzw2Jm0oUMVGNOVST05ac4ynSnJvSMedVJXVoXul71Xyp9KYviHxFofhTSbvXfEWp2ukaTZIGuL27crGu44SONFDyzzythIbeCOW4nkIjhjdyFPThMHisfiKeFwdCeIxFV2hTpq7dtW23aMYxWspzcYRV3KSSuc+KxWHwVCeJxVaFCjTV51JuyXZJK7lJvSMYpyk9IpvQ+MfEn7bOk2169v4U8FXeq2Ub4Go6zqiaU84UEMYtOtrPUWWN2w0Us15HKYx+9tInYrH+kYLwzxE6anj8yp4eo1/Bw1B4hRvtzVp1KKcktJRjTlG/w1JJXfwWL8QKEKjjgsvnXpp/xa9ZUHLvy0oU6rSb1TlNStvBN2XN/wDDb+rf9E80/wD8KK5/+VNdn/EMaH/Q4q/+EcP/AJoOX/iIVb/oV0v/AAqn/wDKA/4bf1b/AKJ5p/8A4UVz/wDKmj/iGND/AKHFX/wjh/8ANAf8RCrf9Cul/wCFU/8A5QfoZX5Efp58y/Ej9qf4f+BLy40fTUufGOuWrvFdW+kzRQaXZzRkh7e61iVZozOrfKyWFrqAiYPHcNDMhjP2uTcC5tmtOGIrOGXYWaUoTxEZSr1IvadPDRcZcrWqdWdHmVpQUou58jm3GWV5bUlQpKePxEG1OFCUY0aclvGdeV1zLqqUKvK7qTjJWPE4/wBuG8+0AzfDi2+yF2zHH4olFwsRztAmbQjE7plSxMCLLtIAh3Bk+ml4YU+T3c5n7Sys5YGPI5dfdWK5knrb3m43v71rP51eItTn97KYcl3osZLnS6e88NZtaX91J/3b3X0n8L/2g/APxQlTTbC4n0TxGYy/9gaz5MNxc7BmQ6XdRyPa6kEGXMMbx3wiSSd7JIY3kX4zPOEs2yOLrVoRxODul9bw3NKEL/D7eDSqUb6LmknS5moKq5NJ/W5PxRlmcyVGlOWHxVr/AFbEcsZztv7GabhVtvypqpypydNRTa9zr5c+jP5Av+D1b/lFl8A/+z//AIWf+s6/tVUAf1+0AfBv7X/i3xPonjv9nqDwZpNlHq+l/ESz1O58aeKrHUpPh54Zk8U6frfw88NweKrzSXivt+oan4hvriytIp7VWXTbhprq2tnnuYPOxs5xqYZQirxqpupNP2UOdSpR52tdXJtLTZ6pXauO0r9tuvc4X4QfA1f2hPG/xD+J/wC0D4ln+L2neFPE978MfAEcNq3g/wAHajZeFroyeLbuLw3od0I9U8O/8Jc0mm6R/ampagNUGgTX+rrfebZC2zoYf6zUq1cTL26hN0qenJBqD998sXrHn0jdu/LeV7qw3ZJLS+r6s/Qmx8H+EtL8Pjwnpvhfw9YeFhA1qPDdno2nW2g/ZnxvgOkRWyWBicgF4zblXPLAnmvTUIKPIoRUNuRRSjb/AA2t+BF+p8A/tG/s/wCg/BXTtP8Aj/8AAKa5+EniHwVr9k/is+HrX+2fDMHgXxNew6P4v1G18Aai8uhK+mx3Nhq91YaZHpFlPp+lXDkQXsFnqFp5uJw0cOlicPejKnJc/KuaHs5vlm1Sfu6JqTS5VaN9Gk1cXfR6329emps/s9+MPHdz+1L8ZtK8cQ6FrlxeeDvBHh248efDux1iPwBq2u+CLSfW4LW7k1WW6Fh4on8N+P7WefTbO+u7GI2OorazSCKURVhp1Hi66qcsrwpxdSkpezlKmnJJ3vabhUTaTa0dnpoNLlVu70e+v/DHvf7TXxOvfhz4CWHRLlrTxH4quZNI027iZkuNPs44fN1XU7Z1wUuYIngtLaVGSW3ub+G7ibfb1+h8FZJTzjNebEwVTB4GCxFanJJwrVHLloUJp7wnJSqTi04zhSlTkrTPkuLs3qZVlvLh5uGKxk3QpTTtKlBRvWrQfSUYuMINNSjOpGcdYHx3+zz8Al+Kst54m8UT3dt4R067a0EdtJ5V9r2pqiTzQJcOkhgsbZJYje3SDzppJRbWskcq3E9r+icX8WPIo08DgY055hWpqpzTXNSwlBtxjJwTSlVm4y9lB+7FR56icXCM/heF+GlnLqYzGSqQwVKbglB8tTE1klKUVNp8tOCa9pNe9Jy5INSUpR+3L/4CfAjTdJmOpeDtB0/S7eJVuL+91PUbMwRs6orzaxNqkVzEzSMiCd7xZGZlTeSwB/MqXFfFNbER9jmOLrV5ybhSp0aNTmaTbUcPGhKEkkm+VU3FJN20P0Kpw3w5Soy9rgMNSoxilKpUq1afKm0k5V5VlNNtpczqJ3dr6n59fG74aeGfh7qthqvgHxhpniHw/qUz+RDZ63p+oaz4fv4MTJBcPYTl5rSVcy6fqCokqNBNb3YEsdvc3363wzneNzehVw+bZdWwmLoxXNKphq1LDYujL3XKCqxtGpF2jWpNuLUozp+65wpfmPEOUYTK61KvluOpYnC1ZPljTxFKrXwtWPvKMnTleUGtaVWyknGUZ6qM6n3J8HvjSmtfBS+8b+LJzJfeCY9Q0/xBcAos2pzaba291Y3CR/8AP1qlteWVsWIVJ9U+0GMIh8tPzDiLht4biWllmAjalmbo1sJDVxoxr1J06kG/5KE6dSfVxocl23q/0TIs/WI4fqZjjZXqZeqtLFS05q0qMIzpzS/nrQqU49pVua1lovgk/wDCwv2lPiW4RhcaleiSSNJZJE0bwr4et5gFTKI5t9OsjcRxlkie6v764DutxqF6zS/q3/CRwXkqunCjScYtxSeJx+LnHV6tc9aryN2clClShZOFKkkvzP8A4VOLc3dnzVal2lJtYfBYWMtFony0qfMldRc6tSV3zVajb+zPD/7GXw6sLSMeIdX8Ra/qJQC4lguLbSNP8zu1tZw29xdRjqP3+pXORzhTxX5xi/EfOKtSX1TD4PCUb+5GUJ4itbtOpKcKcv8At2jD5n32F4ByqlBfWq2KxVW3vSjONClf+5TjGU4r/FVmee/Ez9jiGx0u71f4a6rqN7dWcLzv4a1owXE98kaM8iaVqNtDa4usKBBZXdrILl3Ki+hZUjk9fJfEaVWvTw+dUKNOnUkoLG4bnhGk20k69Gcql6evv1ac1yJX9lK7a8vN+Ao06M6+U1qtSdOLk8JiOWUqiSu1RqwjC09Pdpzg+du3tI6J8z+yV8V9Q0TxKnwy1q5kk0PXWuDoaXLOTo+uxLJcPaQb2xDaasqTJLb7SBqa2zwrE91eNN28f5BRxOCed4aCWKwqh9acErYjCyagqkrL3qmHbi1O/wDAc1JyVOmo8nBGd1cPi1k+Im3h8Rz/AFZTbvQxEU5unG/wwrJSTh/z+UXGznPm6r9sb4nXcdxYfC/SLl4bZrWDWPFTROVN000m/SNJlxtYRQLD/alzGd8c7T6YwKtbOrcHh1klNwq55iIKU1Ulh8ApL4OWNsRiFuuaTl7CEtHFRrrVTTXdx3m81Knk9CbjBwjXxvK/j5nehRfW0eX201qpOVL+Vpv+Af7MGg6v4e07xt8RoLi/OsQpfaL4aW4ns7SLTJVZrW/1aS2aG6uJ75DFeWdpBcxW0Nm0TXn2uS6ktbE4r44xWHxdbLMmnCksPJ0sTjXCNSpKvFpVKWHU1KnCFJ81OpUlCU5VFL2fs4wVSqcNcIYavhaWYZrGVV14qph8JzShCNGSfJUruPLOcqitUhCMlCMHFz53Nwp/SmpfC/4D+HoLdta8J/D7R4JT5FvLrEGlWQneNASiT37xm4lCYZ/neQj53JJJPxVHO+KcXKaw2YZviJR96ccPPEVOVN7uNJNQjfRaKPRH1tXKOHMNGLxGCyuhF+7F14UKfM0tlKo1zO2r1b6sxv8AhGP2Zf8Anz+EH/gX4Y/+Sa6fr3Gv/P3iH/wDHf8AyBh9T4S/595H/wCB4P8A+SD4rfEfQvhL8JU1TwT/AGRi7KaF4Ki0r7Jc6RFdTm4eS7hW3d7aS10yC3vbnCrLA97Hb2c6hbhiDIcmxWf5+6GZfWP3d8VmUq/tIYiVOHIlTk5pTVSvKdKF24zVOU6kXeCFnWa4fJMk9tl/sPfthsvVHknQU5czc4qLcHCjGNSdlzRdSMYSVpM+BvhJ8GPFXxz1nVdZvtVmstIhvmk1/wAT6gst/e32pXWbmW2s0kkQ32oyhxPdTTXCRWkU0c0zSSS29tcfq/EHEmA4Xw1DDUsPGpiJUksJgaTjSpUqMPcjOo0n7KjGzjTjGDlUlFxioqM5w/M8j4fxvEdetiKtaVOhGo3icZVvVqVas/flCmm17Sq7805SkowUlKXM3GEvsqD9jj4TR2ZtpbrxdcXBAzqDavZR3CtwSY4otKWzVcghVktpiFOCzMA1fnMvEbP5VOeMMvhD/n0sPUcGvOUq7qX7tTjr0S0PvY8B5IqfJKWNlK38V14KafdRjRVP5OEvnufLvxt/Zn1P4Y2D+KfDupT+IfCsUsaX32mBIdW0PzpFit5bswYt76zklaOJr6CK0aKeWOOSzWP/AEg/c8M8a0M7qrA4yjDCY+UW6XJJyw+K5U5TjT5/fpVFFOSpTlUUoxbVRy9w+O4h4RrZPSeMwlWeKwUWlU54qNfDcztGU+W0alNtpOpGMHGTScEvePpr9lT4v33jrQr7wh4ku2vPEfheCCa0vp3Z7vVtAdxbrJcuQTNd6VcGG1ubqRhJcw3dg8nm3K3VxJ8Tx3w7SyrFUswwVNU8HjpyjUpQVqeHxaXO4wX2adeHNUhTS5YSp1VHlh7OC+v4Mz2pmWGqYHFz9pi8HGMoVJO86+Gb5VKb+1OjLlhObd5xnTbvPnk/lz9pT4jar8RfiPP4S0tpptE8L6o/h/SdOt9x/tHXln+xahftGOJriW+36dYkFoxZwRvAEe7uTL9xwXk9DJ8mjmFfljicdQWLxFadv3OEcfa0aSf2YRpWrVdm6kmpXVOHL8hxZmtbNM1lgaPNLD4Os8LQpR/5e4nm9nVqNfak6l6VPdckU42c53+pvhf+yj4I8O6TaXnjqxTxV4mnhjlvILieYaJpcrqHazs7S3kiS+MJPlTXd81wlwyebb29qjbD8LnnHuZ4zEVKeV1XgMFGUo05QjH6zXinZVKlSak6XN8UadLkcE+Wc6jVz7HJ+C8vwtCE8xprG4uUVKcZSl9Xoyau6dOEWlU5dpVKnMpNXjGCdj0XU/AP7PWi3Is9Z8P/AAx0m7MazC11MaDYXJhcsqSiC6kilMblHCvt2sVYAkqcePQzbi7Ew9phsZneIp8zjz0Hi6sOZWbjzU1KPMk02r3V13PUrZZwxh5+zr4XKKE7KXJWWGpz5XdKXLNxdnZ2drOz7Gd/wjH7Mv8Az5/CD/wL8Mf/ACTW317jX/n7xD/4Bjv/AJAz+p8Jf8+8j/8AA8H/APJHL/tVfFC78EeB7PRNBumt9a8bvc2sV/bSFZrLQ7RIH1S5tZoyfLnu/tVrYQSjBEF1dz20iXFvHIndwJkdPM8zqYnFU1PDZYoVJUpq8auJqOaoQnF7wp+zqVZR2cqdOE04Tknw8aZxPLsuhh8NNxxGYOdONSLtKnh4KLrThJbSnzwpxfSM5yi1KKa+Zf2df2d7X4k203i/xfJdw+Fbe7ez0/TrSQ21xr1zbkfa3kuh+9t9MtnIt2a223FzcieOO4tvsjmX7bjDi+pk045dlypyx86aqVq1RKcMLCf8NRpv3Z15r30p3hCHK3Cp7RcvyPCvC1PNoSx2Pc44OM3ClSg+SWJnH43Ka96NGD9x8lpznzJThyO/2Vq3wE+A1jo87ar4R0HSNMhiiim1O51S+002weSOCB5NXm1KKVJXneKNZJrktPK6xv5pkKt+c4fiviqriI+wzDF4ivKUpRowo0qynZOUksPGjKLioqTajC0YptWtdfe1+GuG6dCXtsDhqFGKipVpValJwu1GLdd1YyTcmknKd5SaTvez/PD4xfD/AEb4ZeJdP1DwH4ysde0S8kN5pN3pmt2F3rOg39nKkotrqXS7gyK0O6C40/UljtjMRJHsWa1aSX9e4dzfEZ3gq1HNcuq4XE04+zxFOvhqtPDYujUi488I14Wal70K1Fuajo7uNRRj+W59ldDJ8XSq5bj6eIw9R+0oVKWIpTxGGq05J8k3Rlf3fdlSqpR5tVZSheX6TfAn4g3HxK+G+ja/qGDrNs8+ja4yIESbU9O2K12qqFRTfWktpfSoiJHDPcywxKI40J/GeKcohkuc4nCUr/VpqOJwqbu40K12qbbu37KpGpSi23KUYRlJ3kz9Z4bzSWb5Th8VV/3iDlh8S0klKtSteaS0XtIShUaSSjKbilZI/lj/AOD1b/lFl8A/+z//AIWf+s6/tVV86e6f1+0AfKn7YHiLw8Pgv4z8Aym11Xxp47tNB8L+CfCqXgh1jUPFPirxFaaP4T1SwhXM7Lomvxxa21xGu2JtI2F1mlt1k5MbKPsJ09JTqKMKcL2k5zkowkuvuytK/wDdKjun0W/6mt+yHe6VL+z54A0fTtOXRr/wbaah4I8W6MWDXOm+OPC+qXmmeMBe4JIu9T12K811y/7yWPVYp35lzTwTX1anFLlcE6c49VUg2p383K8vnfqEt356r06H0rXUSeWfHDxB4X8LfB74l6541tkv/C9n4L8QR6xpjttOsW99p8+nx6JE38NzrdxdQ6TasdoFzeRFmQZYZV5QhRqyqK8FCXMv5k1bl9ZXsvNjW6t3PmX9hC703wj8LZvhH4kgt/Dnxc8L+MfFUfjfQNRv0fxFr2oXS6d4gtfFLWkz/brixPhbWvDOmG/KNBH9itoJZY5ZYojyZe1Cj7GVo14Tn7SLfvybtJTs9WuSUFfyRU9XfpbT/I5v9t6W5OueAIXz9jj0nXJYOTj7TNeWCXeF3EA+VDZZIUEjaCzbQE/b/DKMPq2bSX8R18LGX+CNOs6etv5pVOrt2V9fyvxCc/rGWRfwKjiXH/HKdJT69o0+nzdtPpn9maG2i+CPgg2yxgTQ61NMyYJkuW8Raus7SMOWkV08o7iSixrEMLGqj4rjWU5cTZnzt3jLDRin0gsHh3BJdE0+bTdty3bZ9dwlGEeHsu5EvejXlJrrN4qvzNvq01y67JJbJHbfFbwhfePfh/4k8I6bc2lnfa1bWsNvc3xmFrE1vqNneMZjBFNNtZLZkXZE53suQBkjzMhzCllWbYLMK0KlSlhpzlOFLl9pJSo1Ka5eeUY3vNN3ktE+p6Gc4GpmWWYvA0pwp1MRCEYzqc3JFxqwqPm5VKW0GtE9Wj4V/wCGKfH/AP0NXg//AL71r/5U1+o/8RLyn/oAzH7sN/8ALz85/wCIf5l/0G4H78R/8pN/xR8KPEPwc/Z6+JOl6vq2l6g+v694UnVtJN20a28Gq2CvFKby1tnV3liibMQO5E2M21mQ8mBz7CcRcX5LXw+Hr0VhMLj4NYj2d3OVCs1KPs5zTSjKS97Zu6V7M6MbkuKyHhbNqNevRqvE4nBSvR57KMa1JOMvaQi03KMX7u6Vm7XT6P8AYhsLVdH8e6oIlN7LqWjWDTkAstrb2t5cJFGSMorzXLvKFIEpSHeD5Me3k8TqtR4nKqHM/ZRoYmqo9HUnUpwcn3ajBKN/hvK3xO/V4eUoLD5lW5f3kq1Ck5dVCEJzUV2vKbcrfFaN/hR91V+Wn6OFAH5JeL7RfDf7UEsdj5dmsHxQ0LUYfJwsUJ1HVNN1RsKyqioGu23xFTCoLRANEOf3/LqjxnA0XVvUcsjxdGXNrKXsaFegtU227U1aV+Z6S0kfiGPgsJxjJUrU1HOMNVjy7RdWtRrPRqyV5u6ty7rVGd+0ezS/HTxt9vaSNPt+iRu2za6Wa+H9GSJkQJyBaBGjba3mjbId5cs23Bvu8LZZ7JJv2WKaV7p1Hi8S2m76fvLpq65dVpaynivXiPMPaNpe0w6btqqawtBJpW/ks1prvrc/Xe1it4ba3htFjS1igiitliIMS28carCsZBIMYjChCCQVAwTX8+TlKU5ym25ylKU3L4nJtuTfm3e/mft8FGMYxgkoRilBLZRSSil5WtbyPAv2g/hDrnxe0jw7p2h6npWmy6PqV3ezvqpuxHLHcWqwKsX2S2uW3qy5beqrt6EnivrOEuIcNw9iMZWxNCvWjiKNOlFUPZ3i4Tcm5e0nBWa2s27nzXE+R4jPKGFpYetRouhVnUk63PZqUOVKPJCbvfe9j88/i38FNd+D40H+3dZ0TU5PEB1L7LFpLX7PCmmCx8+Sf7XZ2yqjtfwrFtZmYrJxhGI/XeH+JcLxE8V9Vw2JoLCex55V/ZJSdf2vKo+zqTbaVKTd0ktNdUfl+d8P4jIlhvrGIw9Z4n2vJGj7S8VR9nzOXPCCSftYpWbb17HV/FSSdPgZ+ztBl1gktfH80iFcK0kes6aLZySMg+VcTmPkBldmwcAjgyFQfFHGE9HONTKYxd9VF4etzr/wKEL9mktDsztyXDvC0dVFwzKTVtG1Xo8j/wDAZyt3Tb1Pur9mO0s7X4JeDGs0jH2tNYu7uRNu6a8bXtThmeVlJ3SRCFLX5juSO3jiIHl7R+XcbVKk+JsyVRv928PTpp3tGmsLRlFRT2UuZz00bm5dbn6NwhCnDh7L3TS99V5zat71R4mspNtbtcqhrqlFR6HvdfKH0pg+KdPtNW8M+IdLvohNZajomq2V1EePMt7mxnhlXPVSUc7WHKnDDkCurA1qmHxuEr0pctWjiaFWnLtOFWMovz1S067HNjKUK2ExVGouanVw9anOPeM6coyX3PfofmN+yFPLF8YreONyqXPhzXIJ1GMSRKttchDkEgCe3hk4wcxgZxkH9u8Qoxlw7JtXcMbhZRfaT9pC/wD4DOS+Z+QcCyaz2KTsp4TERl5pckrf+BRi/kch8HUt7r49+E/7UY4PjK5uGMg+Y6hC95cWW4FGw7alHbj7oKsc7kI3r38ROcOE8f7Bf8y6nBJPT2MlShVtqtFRc+uq6PZ8mRKM+JcH7b/oPqSd1r7WLqTp3Vnr7VR6aPtuv2Gr+eD9zPjr47fs5eKvip42i8T6Nrnh/TrRNDsNLNvqbaiLkzWk97K8gFrY3EXlsLpAv7zdlWyoGM/onC3GOByHLJYLE4XF1qjxVWvz0FR5OWpClFL95VhLmTpu+ltVqfC8R8K4zOcwjjKGIw1KCw9Ojy1va8/NCVSTfuU5Kz51bW+j0Pg34l/D7UPhj4om8KarqGnalfW9nZ3k02mG4NtGL1GlihJuoLeXzVi2SN+727ZEwTzX6rkub0c7wMcfQo1qNKdSpTjGvyc79m1GUlySnHlcrpa3vFn5tm2V1coxksFWq0qtSNOnUlKjzcq9om1H34xle1m9OqPoD9sTz08T+AYJVkRYvAlr+7dSvlznULxJ1IYAiQCOJZFPK7VBA7/JeHXK8Dm0o2blmk9U73j7Gm47dNZNPrdn0vHnMsXlkXdKOXR0ataXtZqXz0imulkfbXwEis4fg58PUsdvknw9byvsAA+2TyzT6hnCqN32+S53nGS+4szElj+Z8VyqS4izd1b831ycVf8A59xUY0e+nslC3lbbY/QuGowjkOVqnbl+qwk7fzycpVei19o53876vc0vjB4J1D4i/DrxF4N0u7s7G/1j+yPIur8zi0i/s/XdM1WXzTbxTzfPDYyRx7Im/eum7am5hjw7mdLJ84weY16dSrSw/wBY5oUuX2kvbYWvQjy88ox0lVTd5L3U7Xdka57l9XNcqxWAozp06lf2HLOpzckfZYmjWfNyqUtY02lZPVq+mp8O/wDDFHj/AP6Grwf/AN961/8AKmv0/wD4iXlP/QBmP3Yb/wCXn53/AMQ9zL/oNwP/AJcf/KT62+AHws174SeFtX8Pa5qel6m1/wCIJdZtn0r7SYYln07TrGVZGu7W1lMjGwQ7QHjChSpDM+fz/izPcLxBj8PjMLQr0FSwkcNNV+Tmk41q1VNKnOceVe1fZt3vokfb8M5NicjwVfC4itRrOpipYiLo8/LFSpUqbTc4Rld+yXdJWtq2fy8/8Hq3/KLL4B/9n/8Aws/9Z1/aqr5Y+kP6/aAPg79q3wv4M8b/ABh/Zj8NSa3qPhn4hT+NdYNl4g8K3v8AZHjXS/DD+EfFOoC80rUJba5tZra38SaFprPHc21/FbO7QSwRW+sTLeedjIQqV8JHmcKntJWlB8tRQ5Ju6dmtJRW6dtrWlrcbpS7W+RwGi3Pxu/Zb+Nmq+ERZ/wDDQWi/HSG++IFlJBJoXw88U/8ACReDrG0sPGa6XprkeGNd8T3Hh46NrWqWyXOjy+IvsMt9bfZL5bm3vM4vEYTEShb6zHEJ1FrGlPmgkp2Xwyny8rkrx5rXVndM0kr7W0777Hvf/DbHwIt4bi01fUfFvh/xra38GkS/CzWfA/iWH4mnWrpEey0i38MWtjdm8ur3zYVtrizvLjTHeaINfoHUnp+v4e1pOcaiaj7GVOfteZ7RUEndvpZta7i5X8u99DwL4l+KvjJ+078QPCHwP0nwddfA7w/aiw+Mup6143GleJPFkug+F9aFp4a/4SH4f2N4+l6Sl/4o8m6svDWvavdzanNopu7qNdMsrmC75qs6+LqQw8YPDxVq7lU5ZzcYStDmpJ8qvPVQlJ35bvRatWim736af5+h2HwJ8F+GvAn7W/xt07xJ4x1jx38Trr4f/DG40jxN4xuLWXxLqGn6jD4hn8aDTrPSrOw0vT9EtZNJ8HWyQRWajTYI9OsY7t2vJvtd4eEKeMxClOVSq6dJxnNrnafM6lkkkorlhpbTRX11G7xWlld7fh+p61+1n8Pbzxj4Btde0q3kutU8E3NzqLW8SNJNNol9FDHrIhRfvPbG1sdQk4J+y2VyFBcqp/TOAc3p5dm08LXmqdDM4Qo88mlGOJpSlLDOTeynz1aK/v1YX0TZ8Vxrlc8flsMTRi51svnOryxTcpYeoorEcqXWPJTqv+5TlbVo+e/2Y/j1o/gW3uvA/jS5ey0G7vJL/RtaKSzQaVeToq3VlfRwpJMljePHHNDcxoyWl287XSi2uZLm0+u434UxGaThmmWwVXF06apYnDJxjOvTg24VaTk1F1aabjKDadSmoqn78FCp8xwhxJQy6M8ux83Tw06jq0MRZyjRqSSU6dRRTkqdRpSjNJqE3Ln9ybnD9D7HxT4Z1SFbnTfEWhajbuqus9jq+n3cLK4JRllt7iRCrgEqQxDAHBOK/IauBxtCThXweKozTacKuHq05JrdOM4JprrpofqNPGYStFTo4rD1YNJqVOvSnFp7NSjJqz6alw6xpIBJ1TTgAMkm9tgAB1JPm8AVn9Xr/wDPmt/4Ln/8iX7ej/z+pf8AgyH+Z4D+1f8A8kT8Rf8AYR8Pf+nqzr6zgL/kpsH/ANecZ/6i1T5jjX/knsV/19wv/qRTPMP2I/8AkV/HP/Ye03/03yV7fib/AL9lf/YJW/8ATyPI8PP9yzH/ALCqX/po+3q/Mj9DCgD8kvjJ/wAnJ61/2N/hn/0l0Sv3/hz/AJIvDf8AYvx3/pzFH4jn3/JW1/8AsPwf/pGHPUP2yPh7d2PiPTviNZQNJpet21tpGtSIu77HrGnxmKylnIA2xajpqRQW5+fbNpsyyOnn20beH4c5vTq4Otk1WSjXw054jDJu3tMPVadWMO8qNZynPa8a0XFPkm17XHmV1KeKpZrTi3RxEIUMQ0v4demrU5S/u1aSUYvW0qUk2uaCPWvgF+0d4W1bwzpPhTxvrFroPiXRbWDTIdQ1W4W203XbK1RYLK4/tGdlgt9SSBYoL2C8mQ3c6C9tpZTczWtn4HFfBuOw+Nr4/LMPUxeCxNSVaVHDwc62FqzblUh7GCcp0XJylSnTi1Tg/Z1Ix5Izqe1w1xVg6+Eo4LMK8MNi8PCNKNWtJQpYmnBKNOftZNRjVUUo1I1JLnkvaQb55Qp/RGufE/4d+HLGTUdY8aeHLW1jXfhNVtbu6mAx8tpYWUlzfXsmDu8mztp5doL7NqsR8fhckzfGVVRw2W4ypNu2tCpThHzqVaqhSpR6c1ScY3sr3aPqcRm+V4Wm6tfH4WEEr6VoTnLyhTpuVSo/7tOEnbW1kfl38XfiBqnx3+I9n/wj+m3j2h+z+HvCWjsEN7Mkk7M1zdIkjQRXd/cyvNPiTybS0jt4ZZ5FtHuZP3Hh/KaHCuTVPrdamqnv4vMMQr+yi4xSUINpTlTpQiox05qlRzlGKdRQX49nmZ1uJM1p/VaVRw93C4Kg7e0knJtzmk3GM6k25S15YQUYyk1Bzf2L8Y/gjd3/AMCvDfh3RUGoeIPhvp9ndwLbgl9VW3sPJ8QwWiMgkd7tt2o2kATz55bSC0RWlmCt+dcOcTU6PFONxmJfscJnNarTm5tWoOdXmwkqjTslTVqNSd+WEakqjfLG591n3D06vDmEwuHXtcVlVKnOKje9ZRpcuKjBWu3Ud6sI25pShGC1lY+eP2dP2hrT4bQTeD/GCXL+Fbm8e8sNStonuZ9Bup8C7Sa0QGa4025ZVnZbYPc2tz50kdvc/anEX2HGPCFTOZxzHLnBY+FNU6tGclCOLpw/huNR2jCtBPkTm1CcOVOcPZrm+W4V4pp5TGWAx6m8HKo50qsIucsNOXxqUEuaVKbXM+S84T5moS53y/oh4X+IPgjxrvHhTxTouuTRw/aJrOyvoW1CC3DRoZ7jTnZL+3h8yWOPzZraOPzHWPdvO2vyDHZRmeW2+v4HE4WLlyRqVaUlSlOzfLCsk6U5Wi3yxm3yq9ran6lg80y7ML/UsZh8TJR5pQp1IurGN0uaVJ2qRjdpXlBK7te+h0Gr/wDIJ1T/ALB17/6TS1yYf+PR/wCv1P8A9LidVf8AgVv+vVT/ANIZ+XX7IEDS/GGGRSoFr4a1ydwc5ZW+yWwC4B+bfcK3OBtVuc4B/cfEOSjw7JNP38bhYrya9pO78rQa9Wj8c4Fi3nqf8uExEn6fu46fOS+VzG+OnhDWfhP8XrnW9NV7S01HWf8AhMvCmoRqfKjmN8L+a1VgAizaVqe6I2xZnFmbKaTCXSZ6eFsww2f8PQwtZqpUo4b+zcfRb95x9k6UKj6uNehaSnZL2iqxWtNmXEeBxGS55LE0U4U6tf6/gqqXuqXtFUlDspUa11yXv7N05PSaPvX4Y/tC+AfiBpNo15rOmeGvEvlKmo6Dq99DYkXSgCR9Lubx4odRtZWzJAsMj3ccXF1BGykn8pzvhHNspxFRU8NXxuCu3RxeHpSqr2b2VeFNSlRnHRS5kqbl8EpJn6TlHE+W5nQg516OExdkquGr1I03zrd0ZTcY1YS3jytzS0nFNG/44+N/w48CaXc3t/4l0vUr6OJmtNC0a/tNR1a+mKkwxLb2ssv2WKVhg3l6YLVAGPmMwCNyZXwznOa14UqWCr0aTklUxWIpVKOHpRv70nOcY88or/l3T5qj/ltqunMeIcqy2jOpVxdGrUUW4YahUhVr1JW92KjBy5E3/wAvKnLBd76P81PD9h4i/aC+M32q4ti767rEera6Y981tovhqyltoZVaRwMwWOnJbaXZecY/tV01nbllkuBX7Ti6uD4S4b5ITssLh3h8Le0Z4nG1YzlFqK+1VrOdepy35IKpOzUD8mwtPFcT59zyhd4iuq+JteUMPhKcoRabdvdp0lCjTvbnm4R0cj7D/bB+Hl54k8JaX4y0q3Nxd+DXuxqsUYzK+gah5BnugoBaQaZdW8MzqoHlWlze3LnZA1fnfh5nFPBZhXy7ETUKeZKn7CUvhWLpc3JC+0fbwnKKf2qkKUFrJH3PHWVVMXgaOPoQ56mAc/bRXxPDVeXmnZXcvYzjGTX2YTqTekTyr9mP9oDRfCmmL8PfG94um6VHcz3Hh3XJtxs7I3szT3Wl6iyhvs1vJdyS3lresvkxy3Nyl3JFF5Lr73G/CWJx9d5vllN1q8oQhjMLG3tKns4qFOvRTtzzVOMac6SfM1CDpxlLmR4vCHE+HwVFZXmNRUqMZylhcTK/s6ftJOU6NVr4IublOFR+6nOam4rlZ9+2fibw3qMK3On+INEvrd8FZ7PVbC5hYEBgVlguHQ5BBGG5BB6GvyapgsZRk4VsJiaU1vCpQqwkumsZQTWvkfpsMXhKsVOnicPUg9pQrU5xfXSUZNP7y2NX0okAanp5LMFUC9tiWZiFVQPMyWZiAAOSSAOTWfsK+/satkrv93PRLVvbZIv29F6KtSu9F+8hq3stzQrI1P5Av+D1b/lFl8A/+z//AIWf+s6/tVUAf1+0AfPH7QP7Pek/HHSdJurPxDrHgD4keEJLu78BfEnwzc3Vnrnhy6vYhDeWzyWN3YXVzpWoRqqXdtDe2lzGVEtpdwFriO55sTho4hRalKnVhd06sG1KLe60abT6q6fZrW9J28090eHeKv2K/EXi7wnoUWo/tF/GF/HfhxxqGl6nqPiSfXPDVprD2lxpeoTWUcqaf49sLPWtIuJ9OvILfx95sUN1IZptSkQyT888DKcI3xNb2kdU3JygpWs7bVEpRbT/AHl9d31fNb7Kt/Xy/A9x0n9l34GWfgZfB198Jvh/exXUEFzrUn9kzz3Goa8IP9J1KPxHq9xq3jCOU3L3H2S/uddvNWtbaZo/tkrNIZOiOEw6p8jo03ezl7t25dXzSbne97NycktLk8zve7/r8Dw/wF+xNqvhCHxLq0nx++LVv4q1+MW0a+EfEc+h6BY6RpP9o/8ACH+Gvtevp4w8b3GieGkv3gtkPiyJpLcsskUkuZZOengHDml9Zrc8tPck4xUY35IXl7So4wvZe/t0Kcr9F/W/Zfgeo/s+fsz2/wAHb7W/Gni/xnrfxV+LPiSD+zNS8feJrrVL68sfDkM6S2XhrRW1vVdb1O306HybZrqW71S6ub6a2tyxhgt4LePbDYVUHKpOcq1aas6k221HpCPM5Oy0vdtuy2skJyvpay7H1NXWSfGnxS/ZE0TxPfXWu+AtQtfCuoXcjzXOiXUEjeHpp5GLPLZtaq9zo4dmZnt4La8swdqWttZxrtP6NkXiDisDShhc1ozx9GmlGGJhNLGRglZRqc7UMTZJJSlOnU3c6lRnweccEYfGVJ4jLasMFVm3KeHnFvCyk3duHJedC7u3GMalPZQhBHgT/scfFpXZVu/B8gVmUSJrF+EcAkB1EmjJIFYfModEfBG5VOQPrF4jZA0m6eYq6Ts8PRuvJ2xLV1s7Nrs2fNPgTO02ufAOz3VerZ+avh07PzSfdI1dE/Y6+J0epWF1f6j4MhtbW/sp7iJtW1dpp7eK4SSdYPs+gyr5hjRlXzJYRuZcMBllwxXiLkkqFWnSo5lKpUpVIQl9Xw6jGcoNRcufFp25mm7Rlonp0e2H4EzeNalOrVwEYQq05TXt67lKEZJyUeXDNXsmldx1a16r7V+OfgbWviL8ONX8K6A9imqXt1pM8J1CeS2tSllqVtdTBpYoLhlbyo3KDyyGYbSRkV+acL5phsnznD4/Fqq6FKGIjJUYxnO9WhOnG0ZTgmuaSv72i1Pv+I8uxGa5TXwWFdNVqk6Eo+1k4QtTqwnK8lGTT5U7aas4v9m74UeKPhToviXT/FD6W8+rapZ3lqdLu5buMRQWjQv5rS2tqUfeRtUKwK85HSvT4zz/AAOfYnBVsCq6hh6FSnU9vTjTfNKopLlUalS6tu21qefwnkuMyXD4uljHRcq9aFSHsZymuWNPlfM5QhZ38mfSVfGH1gUAfB/xD/Zv+IXif4w6j4502bw6NEute0XU4ludSuor0W9jBpqTh4F06RBKGtZQiiYq3yneAeP1PKOMsowPDtHK60cZ9ZhhMVQk4UacqXPVnXcGpusny2qRu+W6100PzbNOFM0xefVcypSwv1eeKw9Zc9WcanJSjRUrx9k1zXhKy5rPTU+3tY0fS/EGl32i61Y2+paVqVu9re2V0nmQ3EMnVWHDKysFeKVGWWGVUmhdJUR1/MsPiK+Er0sThqs6NejNTpVYO0oSXVd09VKLTjKLcZJxbT/RK9CjiaNShXpxq0asXCpTmrxlF9H+aas4tJpppM+FfG37Fckl3LdfD7xRawWssm5NH8UrcgWikKWWLWdOtruW4jDFxDHNpSyxxrGkt3dSF5j+pZZ4lKNONPN8DOc4qzxGBcP3j6OWGrTpxhK1uaUa7i22404K0T85zDgBubnleMhGEndUMZz+5tpGvShOUle/KpUeZJJOc3eRwOm/sY/Eu5nC6lrXhHTLUFd8yXup385Bzkw20elwxyFcDcJbq3B3LtZvm2+rW8SMlhC9HDZhWnraLp0KUP8At6bryav05ac9ne2l/NpcBZtOVquIwNKHWSqVqkv+3YKjFO3XmnHfS+p9ifCP4AeD/hPnULZ5te8USwtDP4h1CGOJoI3G2WHSLFGlTTIJl4lJnu72UNJG961uwgX874g4szHP/wBzNRwmBjJSjg6MnJSktYyxFVqLryi/h92nSjZSVJTTk/usk4ZwOS/vYOWJxkouMsVVik4p7xoU02qMZfa96dR6p1HF8q92r5Y+jPl74nfsreCvH+oz67pF7P4M1y9lebUJrGzj1DStQnkYvLd3GkvcWZivJScyS2V7aRTOXmuLea5kkmb7jI+O8zymjDC4ilDMsLTio0Y1ajpV6MErRpwxChUvTivhjUpVJRVownGEVFfHZxwZl+Z1ZYmhUlgMTUblVlTgqtGrJu7nOg5U7VH1lTqQUneUoym3Ii+BX7PeqfCDxPrWtXniSw1u11LRP7KhjtrG4s7hJGvbK8MsqyzTxhB9meMKkrs25XO3lRXFPF1DiHBYbDU8FVws6OJ9vJzqwqwa9nUpqMXGMHf307uKSs1ruLhzhetkWLxGIni6WIhWw/sYqFOVOSftKc7tOUlb3WtG3s/I+nry3+12l1a7/L+0289vv27tnnRNHv27l3bd2du5c4xuHWviKc+SpCdr8k4zte1+Vp2vra9t7M+vqR54The3PCUb2vbmTV7aXtfa6PlL4Lfs26p8J/Gz+J7jxTYa3ayaHfaWbeHTbixuFmu7izlWQb7m5jaJFtSG+dWLOAFwMn7ziXjOhn+WLAwwFXCzWKpV+eVaFWDjThUi1pTptSbqaaNWW58Xw/wlWyTMHjJY2niIPD1KPJGlKnLmnKnJPWc1ZKHe+ux9BeOvAHhf4jaHLoHirTlvbRmMttcRkQ3+m3W3at5p12FZ7a4UcNw8M8e6C6hnt3eJvksrzbHZPio4vAVnSqJcs4P3qVaF7unWp3SnB/KUXaUJRmlJfUZjlmDzXDvDYykqkHrCS92rSn0qUp2bhJfOMl7s4yi3F/CviX9inxVb3Ej+EfFeiapYks0cOupeaTfxoSdsO+yttUtLl1XaGnY2KSHcwhi4Sv1HBeJeBnBLMMBiaFXROWFdPEUm+srVZ0KkE3e0f3rWi5pbn5zi/D/GRk3gcbh61PVqOJVShUS6RvThWhNr+b92nvyrYp6B+xZ43urhT4k8TeHNHstw3nTPt+s35APIWCa10q1UMOFc3rlSctCcYbTF+JWWU4P6lgcZiKvT2/ssNSXZuUZ4io7PdezV+kuqjDcAZhOa+t4zC0KfX2PtMRU8/dlCjBX6P2jt1j0f3F8NvhX4R+FukHTPDNkRcXKxHVNYuys2q6tLFu2PdzhURIoy7+RaW0cNrAGZki82SWWT8xznPcwz3Ee3xtVcsHL2GHppxoYeMrXVODbblKy56k3KpKyTlyxjGP6HlOTYHJ6HscJT96VvbV52lWryjeznKySSu+WEFGEbtqN3Jv0VlV1ZHVXR1KujAMrKwwyspyGVgSCCCCDg146bTTTaad01o01s0+56rSaaauno09muzPif4m/sd6Xrt/daz8PNVtPDdxdu803h7U4pm0ITyEszafd2iTXel25bn7F9iv4Iy5FqbW3jith+l5J4iV8LShhs3oVMbCmlGOLoyisVyLRKtTqONOvO3/Lz2lKTtep7ScpTPz3OOBKOJqzxGV1oYSc25SwtaMnhuZ6t0pwUp0Yt/wDLv2dWKu+TkilA8OP7HHxbBIFz4QYAkBhrN9hgD1G7SFbB6jcoOOoB4r6j/iI3D/8Az7zFeX1alp92Ja+5nzn+oeefz4F+f1ipr99BP70dN4Q/ZE+J2leI/D2t32p+DIbfR9f0nUriAapq8t1Lbaff213N9nWLQHt2kdI3SJZbiHMgw5jQhzw5j4g5JiMFjMLSoZlKeIwmIowm6GHjTjOtSnTjzt4tTSTknJxhLTZN6HZgeBs4o4vC4ipWwEYUMTQqzj7au5uFKpCcuVRwzi20moqU4672Wp+ktfjJ+sn8gX/B6t/yiy+Af/Z//wALP/Wdf2qqAP6/aACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgD5u/Zs8WeI/Flp8bn8R6vd6u/h79pH4w+E9Ea7ZWOm+HNC1q2t9H0i22qu200+F2jt1bcyqTlmrlws5TVfmk5cuKrwjfpGMrRivJLYqXT/Cj5t+OnxU0LQP2k9a8JfEf9ob4ifBXwTbfC3wprOgQeCbq0gTUvEV7rmvW2pfaVuPBnjAnNhbW7ZENpzGv71+UrlxFaMcVKFXE1aFNUYSj7NpXk5Sve9OfS3YaXu3UU3fr/AMOj7f8AhUNJn+HPhefRPG/iT4jaJqemvqel+NvFVzBL4h17TtYubnUrS6vLix0jw7GoggvEs7Hy9JsJ4LG2tY5Ve5jknk76NvZQ5akqsWrqpNpykpNtNtRjtey91aJX1Je+1vI/LPx1+0r8ZPCfwc8G+FdN8RavrHxa8BfG34s6V8RNUSa2bUtZ8G/BKW71/Xl1aTykthp95oPiHw6JJ4kRby3slFoXkn2HyamKrwoQhGUpVqeIrKq9Lyp4e8pc2lrOMoare2m5airvs0rerPuP4OfEDWPih8cvjbrOneIb68+GHhLRPhp4Z8JaahX+yLzXdc8P/wDCX+JtXVNqut/ZR3+k6YxLSoySSlGEYRpe+hVlVxGIak3ShGlCC6OUo885equkS1ZLu7/5Hif7TPxRtfCv7R3gzwn41+OPjn4MfDS/+EV7rtzfeC7i2guLvxZH4qvbKxjm+0eFvFmVuNPSdZMacnFpD/pEWCsuGLrKGKpwniKlCk6Lk3BpXnztLeE91fp03HFe62km79T69+CDaFdfD3TNY8MfEvxf8WfD2v3N7qmk+MfG1zZ3WrXNuJv7Oks4WsvDvhdY7C0u9PuBBFPpS3Ame4dppY3i29uH5XTUoVZ1oybanUacmtraRhomnbQl77JeSOK+FvizxHrPx/8A2pPDOqavd3ugeDtU+D0PhfS5mU2uixa78NbXVtXSyUKGRb/Una8uNzPumYkbRxWdGcpYjFwcm4wlR5F0jzUlKVvV6je0fO/5n0jXUSfLX7FfjLxR8QP2Zvhr4u8Z61e+IvEurf8ACZf2lrGouj3l59g8f+KtMs/OZEjU/Z7CytbWPCDEUCA5IJPJgJzqYSlOpJynLnvJ7u1SaX3JJFSVpNLy/I1P2vfFniPwN+zj8UPFfhLV7vQfEWj6XpM2mavYMqXdlLP4l0S0leFnV1DSW1xNC2VPySMOvNPGzlTwtacJOMoxVpLde9FfkEdZI88/Z68U/Crxf40ux8Pv2pfi38Y9Q0fRbq91Dwp4uvtNl0SOwnntrEanNFH8NfCk8k9rc3ECW3k6odkku6S3lQHbnhp0Z1H7PF1q7jFtwm1y2dld2pQ1TemvyB3S1il/XqWP2xPG914MtfgwknxI1/4WeGfEfxUh0Txp4r8OXlnYahaeHW8Na9eSbbm/0zWLWMLeWtq4aXTrpQyj92exjajpqh+9lRhOty1JxaTUeST3akt0ujCKvfS+mhzv7M3xE1LxD8XviF4S8J/FzxR8dvg7pfg3RNatvG/inTbJrvw749vNXubW58IQ+JdP0PQYNajudAjttYdPsnk20imO1htpFv5L2cLVcq1WEK08RQUIyVSaV41G2nDnUYqV42ltp0trdyWibVnfby7nS/tG/FfxF+zr408JfF/UbvV9a+DusaHrvgXxl4St8TJo/jGOyvvEfgXxLpSYeaC41+50658I6tPI0elWFtJZ3csM19cRk1iq0sLOFduUqDjKnOC6Ts5U5Lzk04N7JWe4ormTXXdPy6/5nrf7PFl8R4PhVoGqfFnWLzVvH3it7zxfrtvdIsEXhxvEUxv7HwpYWiKq2Np4f057SwezBdYr9L0o7RsuN8MqqoxdaTdSd5yT+zzaqCXRRVlbvcTtfTbb/gn8uH/B6t/yiy+Af/Z//wALP/Wdf2qq3Ef1+0AFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAeU/FWX4029nod18GbX4e6le22pSt4j0jx9c65p0epaVJaSw28ejapo0N2LK8t72SO7uPtlnJHPbw+XFLG+6K5xre3Si6Cptp+9Go5K6tpyuN7NPV3XT72rdb/I5/8AZ6+F/iP4W+DNbtfGmr6TrXjbxt498YfErxjc+HorqLw9D4i8ZaiL29stCF9Fb3zaZbLFCkMl3BBPJIZWMMSFEWcNSnRpyVSUZVKlSdWbjfl5pu7Ub2dl5pegN3emySS+R5j448D/AB+0L4/a78WPhPoXw28R6V4j+G3hrwZdWvjPxLreiXVpdaJretanLNDFpmi3yyJIt9Aqs05BBb5VZaxqU8THEyrUY0pqdKEGpzlFpxlJ9Ivuuo01azvvfQ+l/Atz42u/Cul3HxF0zw/o/jKT7d/bGm+FtQvNV0K22ajdpp/2G/1C2s7ufztKWxnuvNto/KvJbiGPfFGkjddN1HBOqoxnrzKDbitXazaTelm9N7idumx8o6Z+ydE/7SHxz+KetnTZfBHxN8AT+FdK0WKeaa6t9T8WaNo+keO9RnspbYW0DXsOivtmW7lN0usXMbwpHDGIuOOD/wBqxFaVnTq0+RRu7pzjGNR2tZX5d7683kPm91Lqn+Wx2f7HvwL1v9n/AOECeD/FVzp974q1HxLrWv67d6Zcz3to7Si10jSI4bu6gtp5Eh0DR9KHlNCiW0rS28e5U8x9MFh5YahyTac3OUpNNtdIxs3Z/DGPTTYJO7uYfxZ+HXxvT9oLwx8aPhNpHgHXYdK+Fd/4AvdN8aeIdW0T/SNQ8STazJcwf2XpOoPIscKWyIWkQF5JQU+RWaa1LEfWYV6MacuWk6bU5OO8ua+iYJq1nfe+h9DfDi8+JV94fkm+Kui+E9B8TjUblI7Hwbq+o61pB0tYrY2k7Xmp2Vhci8kma6WaEQGJI44WWRi7Bemk6rj++jCM7vSEnKNumrSd9xO3T8T5ovvBf7SXgj42/Gzx58MvDXwr8R+Gvipd/D67gPi/xZr2j6nZN4O8Dad4bmQ2umaHeQhZ71L11LXMhMKQP8jSOi8jhiqdevUpQozhWdNrnnKLXJTUHoovd3HeLSTvpfbzZ9c+GpfEM3h/RpvFtppVh4nl060k16y0O6ub7SLTVHhVry3068vILa5ubSGYtHFNNBE8iruKDNdsOZxjzpKdlzKLbin1SbSbXyJPhn9n7wP+1z8EPh34K+Fcfg74K6t4e8NXepLca1N438TJq0tlrnijVPEN/KlpF4cS1a4tRq9xDax70SUQReayl3I8/DU8bh6VOj7Og4xbvJ1J3tKbk9OW2nM7ehbcW27v7j6M/aY+HPiD4t/Az4g/Drwq+nR+IPE+n6ba6a+q3Mlnp6yWmvaVqUv2m5ht7qSJfs9lMFK28hMmxSAGLDqxVKVbD1aULc00kruy0knq7Pt2Ji7NMh+HusftKXviSKD4n+C/hRofhQ2l201/4Q8W+IdY1lb1UBsokstS0WxtWt5H3CeQzh41AKKxJpUpYpy/e06MYWesJylK/TRxS9dQfL0b+4d8aPhjrXxD8RfA/UtNXSZdO+H3xTtvF/iS21SV1a40VPDuu6ZIllB9luYbu5F1f2x+zzvboYyziQlNtOvRlVnh2uW1OtzzT6x5ZLRWd3drTQE7X81Yxvhb8J/FHwr+L3xYn0R9GHwW+JElt47sNIS5ni1Xwx8TLhrey8TW9hpqWq2f9h+I7aP+1p7gXQa1urWysLazSFZZWmjRnRr1nHl9hVtUSvrCq9J2Vrcslq3fRpJLcbd0u60+Rd/ai+F3iX4xfCHUvBHhOTS4taufEPg/VYm1i6ms7I22heJtM1W9UzwWt46zG0tZjAph2ySBUZ03A08XRlXounC3Nz05e87K0ZpvZPohRdnf1PoaukR/IF/werf8osvgH/2f/wDCz/1nX9qqgD+v2gAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKAP5Av+D1b/lFl8A/+z//AIWf+s6/tVUAf1+0AFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQB/IF/werf8osvgH/2f/8ACz/1nX9qqgD+v2gAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKAP5Av8Ag9W/5RZfAP8A7P8A/hZ/6zr+1VQB/X7QAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFAH8gX/AAerf8osvgH/ANn/APws/wDWdf2qqAP/2Q==';
        //header::customer copy
        //add image: x, y,width,length;
        doc.addImage(engageLogo,'JPEG', 5, 0, 75, 35);
        doc.setFontSize(8);
        //text: x,y,content
        doc.text(140,10,'Section 1: Customer Copy');
        doc.text(140,15,'Address: 83 Hawthorn Rd, North Caulfield VIC 3161');
        doc.text(140,20,'Phone: (03) 9530 0870');
        doc.text(140,25,'ABN: 68 979 045 252');
        doc.text(140,30,'Website: engagejewellery.com.au/');
        doc.text(152,35,'engagediamonds.com.au/');

        //content::customer copy
        doc.setDrawColor(10);
        doc.rect(10,92,120,30,'D');

        doc.setFontSize(20);
        doc.setFontType('bold');
        doc.text(10,45,'Order Number: ' + orderNum);
        doc.setLineWidth(0.5);
        doc.line(5,48,200,48);
        doc.setFontSize(10);
        doc.setFontType('normal');
        doc.text(10,60,'Customer:                ' + custName );
        doc.text(10,65,'Phone:                      ' + custContact);
        doc.text(10,70,'Date Today:              ' + dateToday);
        doc.text(10,75,'Date Created:           '  +dateCreated);
        doc.text(10,80,'Order Status:            ' +orderStatus);
        doc.text(10,85,'Payment Status:       ' +paymentStatus);
        doc.text(10,90,'Description: ');
        var splitTitle = doc.splitTextToSize(description, 120);
        doc.text(11, 96, splitTitle);
        doc.setFontType('bold');
        doc.text(10,127,'Quote:                        ' + quote);
        doc.text(10,132,'Balance Remaining: '+ balanceRemaining);

        doc.setFontSize(20);
        doc.text(200,50,'C');
        doc.text(200,57,'U');
        doc.text(200,64,'S');
        doc.text(200,71,'T');
        doc.text(200,78,'O');
        doc.text(200,85,'M');
        doc.text(200,92,'E');
        doc.text(200,99,'R');
        doc.text(200,113,'C');
        doc.text(200,120,'O');
        doc.text(200,127,'P');
        doc.text(200,134,'Y');

        //footer::customer copy
        doc.setFontSize(8);
        doc.setFontType('normal');
        doc.text(10,137,'Visit orders.engagejewellery.com.au/vieworder/ to check your order progress.');
        doc.text(10,141,'PLEASE NOTE: We reserve the right to require proof of I.D. should the receipt be mislaid.'
            +' All items left for repair are at owners risk. Completed guarantee ');
        doc.text(10,145,'or receipt must accompany repair under warranty otherwise normal charges will apply.');
        doc.setDrawColor(0);
        doc.line(0, 150, 210, 150);

        //header::store copy
        //add image: x, y,width,length;
        doc.addImage(engageLogo,'JPEG', 5, 155, 75, 35);
        doc.setFontSize(8);
        //text: x,y,content
        doc.text(140,165,'Section 2: Store Copy');
        doc.text(140,170,'Address: 83 Hawthorn Rd, North Caulfield VIC 3161');
        doc.text(140,175,'Phone: (03) 9530 0870');
        doc.text(140,180,'ABN: 68 979 045 252');
        doc.text(140,185,'Website: engagejewellery.com.au/');
        doc.text(152,190,'engagediamonds.com.au/');

        //content::store copy
        doc.setDrawColor(10);
        doc.rect(10,257,120,25,'D');
        doc.rect(182,256,5,5,'D');

        doc.setFontSize(20);
        doc.setFontType('bold');
        doc.text(10,200,'Order Number: ' + orderNum);
        doc.setLineWidth(0.5);
        doc.line(5,203,200,203);
        doc.setFontSize(10);
        doc.setFontType('normal');
        doc.text(10,215,'Customer:               ' + custName );
        doc.text(10,220,'Phone:                     ' + custContact);
        doc.text(10,225,'Date Created:           '  +dateCreated);
        doc.text(10,230,'Email:                        ' +custEmail);
        doc.text(10,235,'Address:                   ' +custAddress);
        doc.text(10,240,'Suburb:                    ' +custSuburb);
        doc.text(10,245,'Postcode:                 ' +custPost);
        doc.text(10,250,'Vendor:                      ' +vendor);
        doc.text(10,255,'Description: ');
        var splitTitle = doc.splitTextToSize(description, 120);
        doc.text(11, 261, splitTitle);

        doc.setFontType('bold');
        doc.text(140,255,'Quote:                        ' + quote);
        doc.text(140,260,'Payment received?');

        doc.setFontSize(20);
        doc.text(200,210,'S');
        doc.text(200,217,'T');
        doc.text(200,224,'O');
        doc.text(200,231,'R');
        doc.text(200,238,'E');
        doc.text(200,252,'C');
        doc.text(200,259,'O');
        doc.text(200,266,'P');
        doc.text(200,273,'Y');

        //footer::store copy
        doc.setFontSize(8);
        doc.text(10,285,'ITEM(S) RECEIVED IN GOOD ORDER AND CONDITION:');
        doc.setFontType('normal');
        doc.text(58,289,'(Receiver Signature):____________________________');
        doc.text(148,289,'(Date):_______________________________');



        return doc;

    }
    $(document).ready(function (){
        generatePDF().save('Order.pdf');
        $("#download").click(function(){
            generatePDF().output('dataurlnewwindow');
        });
    });

</script>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="alert alert-warning alert-dismissible" role="alert" style="text-align: center;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Note:</strong> Currently automatic downloads are not supported on Safari
            </div>
        </div>
        <div class="col" style="text-align: center;">
            <button class="btn btn-primary" id="download" >
                <i class="glyphicon glyphicon-print right-pad-5px"></i>Click Here to Manually Download PDF
            </button>
        </div>
        <div class="col" style="text-align: center; padding-top: 20px;">
            <form class="form-inline">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Send PDF to Email (Coming)">
                </div>
                <button type="submit" class="btn btn-success" style="margin-bottom: 16px;">Send</button>
            </form>
        </div>
    </div>
</div>
