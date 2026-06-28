// Single source of truth for company data used across the marketing pages.
export const site = {
    name: 'Metanoia Energy',
    shortName: 'Metanoia',
    tagline: 'Think Beyond Energy',
    yearsExperience: '6+',

    phone: '01037444473',
    phoneIntl: '201037444473',
    email: 'info@metanoiaenergy.com',
    address: '403, Seven Stars Mall, Sadat City, Egypt',
    mapsQuery: 'Seven+Stars+Mall+Sadat+City+Egypt',
    hours: 'Sunday – Thursday · 9:00 AM – 5:00 PM',
    trn: '780-256-441',

    founderName: 'Tarek Said',
    founderRole: 'Founder & CEO',
    founderEmail: 'tarek@metanoiaenergy.com',

    whatsapp: 'https://wa.me/201037444473',
    whatsappMsg:
        'https://wa.me/201037444473?text=Hello%20Metanoia%20Energy%2C%20I%27d%20like%20a%20free%20solar%20consultation.',

    social: {
        instagram: 'https://www.instagram.com/metanoiaenergy/',
        tiktok: 'https://www.tiktok.com/@metanoia.energy',
    },
};

export type Site = typeof site;
