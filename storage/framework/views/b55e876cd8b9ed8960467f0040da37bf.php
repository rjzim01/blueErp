<?php if (isset($component)) { $__componentOriginalbe23554f7bded3778895289146189db7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbe23554f7bded3778895289146189db7 = $attributes; } ?>
<?php $component = Filament\View\LegacyComponents\Page::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Filament\View\LegacyComponents\Page::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="p-6">
        <div class="mb-6">
            <input 
                type="text" 
                id="quickSearch"
                placeholder="Search modules... (Ctrl+K)" 
                class="w-full px-4 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                onkeyup="filterLinks(this.value)"
                onfocus="showAll()"
            />
        </div>

        <div id="linksContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="link-group" data-label="<?php echo e(strtolower($group['group'])); ?>">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2"><?php echo e($group['group']); ?></h3>
                    <div class="space-y-1">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($item['url']); ?>" 
                               class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors link-item"
                               data-label="<?php echo e(strtolower($item['label'])); ?>">
                                <span class="text-gray-700 dark:text-gray-200"><?php echo e($item['label']); ?></span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div id="noResults" class="hidden text-center py-8 text-gray-500">
            No modules found matching your search.
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbe23554f7bded3778895289146189db7)): ?>
<?php $attributes = $__attributesOriginalbe23554f7bded3778895289146189db7; ?>
<?php unset($__attributesOriginalbe23554f7bded3778895289146189db7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbe23554f7bded3778895289146189db7)): ?>
<?php $component = $__componentOriginalbe23554f7bded3778895289146189db7; ?>
<?php unset($__componentOriginalbe23554f7bded3778895289146189db7); ?>
<?php endif; ?>

<script>
function filterLinks(query) {
    query = query.toLowerCase();
    const groups = document.querySelectorAll('.link-group');
    const items = document.querySelectorAll('.link-item');
    let hasResults = false;

    if (query === '') {
        groups.forEach(g => g.style.display = 'block');
        items.forEach(i => i.style.display = 'flex');
        document.getElementById('noResults').classList.add('hidden');
        return;
    }

    items.forEach(item => {
        const label = item.getAttribute('data-label');
        if (label.includes(query)) {
            item.style.display = 'flex';
            hasResults = true;
        } else {
            item.style.display = 'none';
        }
    });

    groups.forEach(group => {
        const visibleItems = group.querySelectorAll('.link-item[style="display: flex"], .link-item:not([style*="display"])');
        if (visibleItems.length > 0 || query === '') {
            group.style.display = 'block';
        } else {
            group.style.display = 'none';
        }
    });

    if (hasResults) {
        document.getElementById('noResults').classList.add('hidden');
    } else {
        document.getElementById('noResults').classList.remove('hidden');
    }
}

function showAll() {
    filterLinks('');
    document.getElementById('quickSearch').value = '';
}

document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('quickSearch').focus();
    }
});
</script><?php /**PATH /var/www/html/resources/views/filament/pages/quick-links.blade.php ENDPATH**/ ?>