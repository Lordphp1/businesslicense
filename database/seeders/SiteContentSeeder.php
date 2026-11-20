<?php

namespace Database\Seeders;

use App\Models\Industry;
use App\Models\InvestmentOpportunity;
use App\Models\NewsPost;
use App\Models\Permit;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    /**
     * Provisional editorial content for the public site.
     *
     * All investment figures and timelines are display placeholders that must
     * be confirmed before publication; nothing here represents official data.
     */
    public function run(): void
    {
        $industries = [
            ['slug' => 'agriculture', 'name' => 'Agriculture & Agribusiness', 'icon' => 'sprout', 'summary' => 'Cultivation, processing and value-chain development.', 'image_key' => 'sectors.agriculture', 'sort' => 1],
            ['slug' => 'manufacturing', 'name' => 'Manufacturing & Industry', 'icon' => 'factory', 'summary' => 'Light and heavy manufacturing, assembly and fabrication.', 'image_key' => 'sectors.manufacturing', 'sort' => 2],
            ['slug' => 'technology', 'name' => 'Technology & Innovation', 'icon' => 'cpu', 'summary' => 'Software, data infrastructure and applied technology.', 'image_key' => 'sectors.technology', 'sort' => 3],
            ['slug' => 'energy', 'name' => 'Energy & Utilities', 'icon' => 'zap', 'summary' => 'Renewable generation, transmission and efficiency.', 'image_key' => 'sectors.energy', 'sort' => 4],
            ['slug' => 'mining', 'name' => 'Mining & Minerals', 'icon' => 'mountain', 'summary' => 'Exploration, extraction and mineral processing.', 'image_key' => 'sectors.mining', 'sort' => 5],
            ['slug' => 'tourism', 'name' => 'Tourism & Hospitality', 'icon' => 'plane', 'summary' => 'Destination development, hotels and visitor services.', 'image_key' => 'sectors.tourism', 'sort' => 6],
            ['slug' => 'logistics', 'name' => 'Logistics & Trade', 'icon' => 'ship', 'summary' => 'Ports, freight corridors and distribution networks.', 'image_key' => 'infrastructure.port', 'sort' => 7],
            ['slug' => 'infrastructure', 'name' => 'Infrastructure', 'icon' => 'landmark', 'summary' => 'Transport, utilities and public infrastructure projects.', 'image_key' => 'infrastructure.transport', 'sort' => 8],
            ['slug' => 'healthcare', 'name' => 'Healthcare', 'icon' => 'stethoscope', 'summary' => 'Clinical facilities, diagnostics and medical services.', 'image_key' => 'sectors.healthcare', 'sort' => 9],
            ['slug' => 'education', 'name' => 'Education', 'icon' => 'graduation-cap', 'summary' => 'Schools, vocational training and higher education.', 'image_key' => 'sectors.education', 'sort' => 10],
            ['slug' => 'financial-services', 'name' => 'Financial Services', 'icon' => 'shield-check', 'summary' => 'Banking support services, insurance and advisory.', 'image_key' => 'agency.finance', 'sort' => 11],
            ['slug' => 'real-estate', 'name' => 'Real Estate & Construction', 'icon' => 'building-2', 'summary' => 'Commercial, residential and industrial development.', 'image_key' => 'infrastructure.construction', 'sort' => 12],
        ];

        foreach ($industries as $industry) {
            Industry::updateOrCreate(['slug' => $industry['slug']], [
                'name' => $industry['name'],
                'icon' => $industry['icon'],
                'summary' => $industry['summary'],
                'image_key' => $industry['image_key'],
                'is_priority' => $industry['sort'] <= 8,
                'sort_order' => $industry['sort'],
                'is_active' => true,
            ]);
        }

        $ind = fn (string $slug): ?int => Industry::where('slug', $slug)->value('id');

        $opportunities = [
            ['slug' => 'regional-logistics-hub', 'title' => 'Regional Logistics & Distribution Hub', 'summary' => 'Development of a modern warehousing and distribution campus serving regional freight corridors, with dedicated customs-handling facilities.', 'industry' => 'logistics', 'location' => 'Jebel Ali Free Zone (JAFZA), Dubai', 'investment_min' => '$15,000,000', 'investment_max' => '$35,000,000', 'featured' => true, 'image_key' => 'opportunities.warehouse', 'sort' => 1],
            ['slug' => 'light-manufacturing-park', 'title' => 'Light Manufacturing Park — Phase One', 'summary' => 'Serviced industrial plots for assembly, fabrication and packaging operations, with shared utilities and site management.', 'industry' => 'manufacturing', 'location' => 'Dubai Industrial City, Dubai', 'investment_min' => '$10,000,000', 'investment_max' => '$25,000,000', 'featured' => false, 'image_key' => 'sectors.manufacturing_work', 'sort' => 2],
            ['slug' => 'utility-scale-solar', 'title' => 'Utility-Scale Solar Programme', 'summary' => 'Participation in a pipeline of grid-connected renewable generation projects, structured for independent power producers.', 'industry' => 'energy', 'location' => 'Mohammed bin Rashid Solar Park, Dubai', 'investment_min' => '$50,000,000', 'investment_max' => '$120,000,000', 'featured' => false, 'image_key' => 'sectors.energy', 'sort' => 3],
            ['slug' => 'agribusiness-processing', 'title' => 'Agribusiness Processing Facility', 'summary' => 'Value-addition processing for agricultural output, including cold-chain storage and packaging for export markets.', 'industry' => 'agriculture', 'location' => 'Al Ain Industrial City, Abu Dhabi', 'investment_min' => '$8,000,000', 'investment_max' => '$18,000,000', 'featured' => false, 'image_key' => 'sectors.agriculture_work', 'sort' => 4],
            ['slug' => 'hospitality-resort-development', 'title' => 'Hospitality & Resort Development', 'summary' => 'A coastal resort and conference facility project in an emerging tourism destination.', 'industry' => 'tourism', 'location' => 'Al Marjan Island, Ras Al Khaimah', 'investment_min' => '$25,000,000', 'investment_max' => '$60,000,000', 'featured' => false, 'image_key' => 'sectors.tourism', 'sort' => 5],
            ['slug' => 'technology-campus-incubator', 'title' => 'Technology Campus & Incubator', 'summary' => 'Mixed technology campus with coworking, data infrastructure and incubation services for early-stage firms.', 'industry' => 'technology', 'location' => 'Dubai Internet City, Dubai', 'investment_min' => '$12,000,000', 'investment_max' => '$30,000,000', 'featured' => false, 'image_key' => 'sectors.technology', 'sort' => 6],
            ['slug' => 'specialty-clinic-network', 'title' => 'Specialty Clinic Network', 'summary' => 'Rollout of specialty outpatient clinics with diagnostics and telemedicine support.', 'industry' => 'healthcare', 'location' => 'Dubai Healthcare City, Dubai', 'investment_min' => '$6,000,000', 'investment_max' => '$15,000,000', 'featured' => false, 'image_key' => 'sectors.healthcare', 'sort' => 7],
        ];

        foreach ($opportunities as $opportunity) {
            InvestmentOpportunity::updateOrCreate(['slug' => $opportunity['slug']], [
                'title' => $opportunity['title'],
                'summary' => $opportunity['summary'],
                'industry_id' => $ind($opportunity['industry']),
                'location' => $opportunity['location'],
                'investment_min' => $opportunity['investment_min'],
                'investment_max' => $opportunity['investment_max'],
                'status' => 'published',
                'is_featured' => $opportunity['featured'],
                'image_key' => $opportunity['image_key'],
                'sort_order' => $opportunity['sort'],
            ]);
        }

        $posts = [
            ['slug' => 'agency-opens-investor-enquiries', 'title' => 'Agency opens investor enquiry desk for the coming cycle', 'excerpt' => 'The agency has begun scheduling structured enquiry meetings for investors exploring establishment opportunities.', 'category' => 'news', 'image_key' => 'news.briefing', 'featured' => true, 'days' => 2],
            ['slug' => 'business-setup-guide-published', 'title' => 'Updated business setup guide published for local and foreign investors', 'excerpt' => 'A revised overview of the establishment process, documentation and expected stages is now available.', 'category' => 'publication', 'image_key' => 'news.newspaper', 'featured' => false, 'days' => 9],
            ['slug' => 'sector-briefing-logistics', 'title' => 'Sector briefing: logistics corridors under review', 'excerpt' => 'A provisional briefing on planned corridor studies and what they may mean for distribution investors.', 'category' => 'news', 'image_key' => 'infrastructure.port', 'featured' => false, 'days' => 16],
            ['slug' => 'registration-assistance-desk-live', 'title' => 'Registration assistance desk moves to staged applications', 'excerpt' => 'Applicants can now complete establishment documentation in stages, saving progress between sessions.', 'category' => 'press-release', 'image_key' => 'agency.team', 'featured' => false, 'days' => 23],
        ];

        foreach ($posts as $post) {
            NewsPost::updateOrCreate(['slug' => $post['slug']], [
                'title' => $post['title'],
                'excerpt' => $post['excerpt'],
                'body' => "Full editorial content for this item is pending review by the agency's communications team. This placeholder exists to demonstrate the news template and must be replaced with approved copy before publication.",
                'category' => $post['category'],
                'image_key' => $post['image_key'],
                'is_featured' => $post['featured'],
                'published_at' => now()->subDays($post['days']),
            ]);
        }

        /**
         * Permit catalogue. Fees are deliberately unset until the desk supplies
         * approved pricing, so the public page shows "On assessment" rather than
         * an invented figure. firstOrCreate keeps any pricing staff have since set.
         */
        $permits = [
            [
                'slug' => 'general-business-license',
                'name' => 'General Business License',
                'authority' => 'Local licensing authority',
                'summary' => 'The baseline operating license for a business premises within the relevant local jurisdiction.',
                'sort' => 1,
            ],
            [
                'slug' => 'employer-identification-number',
                'name' => 'Employer Identification Number (EIN)',
                'authority' => 'Internal Revenue Service',
                'summary' => 'The federal tax identification number used for payroll, banking and federal filings.',
                'sort' => 2,
            ],
            [
                'slug' => 'doing-business-as',
                'name' => 'Doing Business As (DBA)',
                'authority' => 'State or county registration office',
                'summary' => 'Registration of the trading name under which the business presents itself to customers.',
                'sort' => 3,
            ],
            [
                'slug' => 'federal-permits',
                'name' => 'Federal Permits',
                'authority' => 'Relevant federal agency',
                'summary' => 'Federal authorisations required by the specific activity, confirmed against the agency that regulates it.',
                'sort' => 4,
            ],
            [
                'slug' => 'sales-tax-permit',
                'name' => 'Sales Tax Permit',
                'authority' => 'State tax authority',
                'summary' => 'Registration enabling the business to collect and remit sales tax where it trades.',
                'sort' => 5,
            ],
        ];

        foreach ($permits as $permit) {
            Permit::firstOrCreate(['slug' => $permit['slug']], [
                'name' => $permit['name'],
                'authority' => $permit['authority'],
                'summary' => $permit['summary'],
                'fee' => null,
                'currency' => 'USD',
                'turnaround' => null,
                'sort_order' => $permit['sort'],
                'is_active' => true,
            ]);
        }
    }
}
