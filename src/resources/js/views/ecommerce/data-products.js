import img1 from '../../../images/product/img-1.png';
import img2 from '../../../images/product/img-2.png';
import img3 from '../../../images/product/img-3.png';
import img4 from '../../../images/product/img-4.png';
import img5 from '../../../images/product/img-5.png';
import img6 from '../../../images/product/img-6.png';

const clothsData = [
    {
        id: 1,
        product: img1,
        discount: 10,
        name: "Half sleeve T-shirt",
        oldprice: 450,
        newprice: 405,
        feature: [
            "Fit Type: Regular Fit",
            "highest quality fabric",
            "Suitable for all weather condition",
            "Excellent Washing and Light Fastness"
        ],
        specification: [
            {
                key: "size",
                value: "M"
            },
            {
                key: "color",
                value: "Red"
            }
        ],
        images: [
            img1,
            img5,
            img3,
            img6
        ],
        colorVariant: [
            {
                key: "Red",
                value: img1
            },
            {
                key: "Black",
                value: img1
            }
        ]
    },
    {
        id: 2,
        product: img2,
        name: "Light blue T-shirt",
        discount: 20,
        oldprice: 225,
        newprice: 175,
        feature: [
            "Fit Type: Regular Fit",
            "highest quality fabric",
            "Suitable for all weather condition",
            "Excellent Washing and Light Fastness"
        ],
        specification: [
            {
                key: "size",
                value: "M"
            },
            {
                key: "Color",
                value: "Light Blue"
            }
        ],
        images: [
            img2,
            img1,
            img5,
            img3
        ],
        colorVariant: [
            {
                key: "Red",
                value: img2
            },
            {
                key: "Yellow",
                value: img2
            },
            {
                key: "Green",
                value: img2
            }
        ]
    },
    {
        id: 3,
        product: img3,
        discount: 14,
        name: "Black Color T-shirt",
        oldprice: 177,
        newprice: 152,
        feature: [
            "Fit Type: Regular Fit",
            "highest quality fabric",
            "Suitable for all weather condition",
            "Excellent Washing and Light Fastness"
        ],
        specification: [
            {
                key: "size",
                value: "M"
            },
            {
                key: "color",
                value: "Black"
            }
        ],
        images: [
            img3,
            img1,
            img5,
            img2
        ],
        colorVariant: [
            {
                key: "Black",
                value: img3
            },
            {
                key: "Yellow",
                value: img3
            }
        ]
    },
    {
        id: 4,
        product: img4,
        name: "Hoodie (Blue)",
        discount: 5,
        oldprice: 150,
        newprice: 145,
        feature: [
            "Fit Type: Regular Fit",
            "highest quality fabric",
            "Suitable for all weather condition",
            "Excellent Washing and Light Fastness"
        ],
        specification: [
            {
                key: "size",
                value: "M"
            },
            {
                key: "color",
                value: "Blue"
            }
        ],
        images: [
            img4,
            img4,
            img4,
            img4
        ],
        colorVariant: [
            {
                key: "Blue",
                value: img4
            },
            {
                key: "Pink",
                value: img4
            }
        ]
    },
    {
        id: 5,
        product: img5,
        discount: 14,
        name: "Half sleeve T-Shirt",
        oldprice: 177,
        newprice: 152,
        feature: [
            "Fit Type: Regular Fit",
            "highest quality fabric",
            "Suitable for all weather condition",
            "Excellent Washing and Light Fastness"
        ],
        specification: [
            {
                key: "size",
                value: "M"
            },
            {
                key: "color",
                value: "Pink"
            }
        ],
        images: [
            img5,
            img1,
            img2,
            img3
        ],
        colorVariant: [
            {
                key: "Pink",
                value: img5
            },
            {
                key: "Yellow",
                value: img5
            }
        ]
    },
    {
        id: 6,
        product: img6,
        discount: 22,
        name: "Green color T-shirt",
        oldprice: 240,
        newprice: 225,
        feature: [
            "Fit Type: Regular Fit",
            "highest quality fabric",
            "Suitable for all weather condition",
            "Excellent Washing and Light Fastness"
        ],
        specification: [
            {
                key: "size",
                value: "M"
            },
            {
                key: "color",
                value: "Green"
            }
        ],
        images: [
            img6,
            img3,
            img2,
            img1
        ],
        colorVariant: [
            {
                key: "Black",
                value: img6
            },
            {
                key: "Yellow",
                value: img6
            }
        ]
    }
];

export { clothsData };
